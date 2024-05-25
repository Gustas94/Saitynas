<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filtering
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('specifications', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sort_by = $request->get('sort_by', 'id');
        $order = $request->get('order', 'asc');
        $query->orderBy($sort_by, $order);

        $products = $query->paginate(30);
        $categories = Product::select('category')->distinct()->get();

        return view('employee.products.index', compact('products', 'categories', 'sort_by', 'order'));
    }

    public function create()
    {
        return view('employee.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'nullable',
            'specifications' => 'array',
            'specifications.key.*' => 'required_with:specifications.value.*',
            'specifications.value.*' => 'required_with:specifications.key.*',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate images
            'main_image' => 'required|integer|min:0',
            'hasDiscount' => 'boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'specifications' => implode(
                '; ',
                array_map(
                    function ($key, $value) {
                        return "$key: $value";
                    },
                    $request->specifications['key'],
                    $request->specifications['value']
                )
            ),
            'price' => $request->price,
            'hasDiscount' => $request->hasDiscount ?? false
        ]);

        if ($product->hasDiscount && $request->filled('discount_percentage')) {
            Discount::create([
                'product_id' => $product->id,
                'discount_percentage' => $request->discount_percentage
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/' . $product->id, 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_main' => $index == $request->main_image,
                ]);
            }
        }

        return redirect()->route('employee.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('employee.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('employee.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Log::info('Update method called for product ID: ' . $product->id);

        try {
            $request->merge([
                'hasDiscount' => filter_var($request->hasDiscount, FILTER_VALIDATE_BOOLEAN)
            ]);

            $validated = $request->validate([
                'name' => 'required',
                'category' => 'required',
                'description' => 'nullable',
                'specifications' => 'array',
                'specifications.key.*' => 'required_with:specifications.value.*',
                'specifications.value.*' => 'required_with:specifications.key.*',
                'price' => 'required|numeric',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'main_image' => 'nullable|integer|min:0',
                'hasDiscount' => 'boolean',
                'discount_percentage' => 'nullable|numeric|min:0|max:100'
            ]);
            // Log::info('Validation passed for product ID: ' . $product->id, ['validated' => $validated]);
        } catch (\Exception $e) {
            // Log::error('Validation failed for product ID: ' . $product->id, ['error' => $e->getMessage()]);
            return back()->with('error', 'Validation failed.');
        }

        \DB::beginTransaction();

        try {
            // Log::info('Updating product with ID: ' . $product->id);

            $product->update([
                'name' => $validated['name'],
                'category' => $validated['category'],
                'description' => $validated['description'],
                'specifications' => implode(
                    '; ',
                    array_map(
                        function ($key, $value) {
                            return "$key: $value";
                        },
                        $validated['specifications']['key'],
                        $validated['specifications']['value']
                    )
                ),
                'price' => $validated['price'],
                'hasDiscount' => $validated['hasDiscount'] ?? false
            ]);

            // Log::info('Product updated successfully with ID: ' . $product->id);

            if ($product->hasDiscount && $request->filled('discount_percentage')) {
                // Log::info('Updating discount for product ID: ' . $product->id);

                if ($product->discount) {
                    $product->discount->update([
                        'discount_percentage' => $request->discount_percentage
                    ]);
                } else {
                    Discount::create([
                        'product_id' => $product->id,
                        'discount_percentage' => $request->discount_percentage
                    ]);
                }

                // Log::info('Discount updated for product ID: ' . $product->id);
            } elseif (!$product->hasDiscount && $product->discount) {
                // Log::info('Deleting discount for product ID: ' . $product->id);

                $product->discount->delete();
            }

            if ($request->hasFile('images')) {
                // Log::info('Updating images for product ID: ' . $product->id);

                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products/' . $product->id, 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_main' => $index == $request->main_image,
                    ]);
                }
            }

            // Update the main image
            if ($request->has('main_image')) {
                // Log::info('Updating main image for product ID: ' . $product->id);

                foreach ($product->images as $index => $img) {
                    $img->is_main = ($index == $request->main_image);
                    $img->save();
                }
            }

            \DB::commit();

            // Log::info('Product update committed for product ID: ' . $product->id);

            return redirect()->route('employee.products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();

            // Log::error('Product update failed for product ID: ' . $product->id, ['error' => $e->getMessage()]);

            return back()->with('error', 'Failed to update the product.');
        }
    }





    public function destroyImage(ProductImage $image)
    {
        // Delete the image file from storage
        Storage::delete('public/' . $image->image_path);


        // Delete the image record from the database
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete the images associated with the product
        foreach ($product->images as $image) {
            Storage::delete('public/' . $image->image_path);
            $image->delete();
        }

        // Delete the product
        $product->delete();

        return redirect()->route('employee.products.index')->with('success', 'Product deleted successfully.');
    }
}

