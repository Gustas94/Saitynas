<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filtering
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category', $request->category);
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
            'main_image' => 'required|integer|min:0'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'specifications' => implode('; ', array_map(
                function ($key, $value) {
                    return "$key: $value";
                },
                $request->specifications['key'],
                $request->specifications['value']
            )
            ),
            'price' => $request->price,
        ]);

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
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'nullable',
            'specifications' => 'array',
            'specifications.key.*' => 'required_with:specifications.value.*',
            'specifications.value.*' => 'required_with:specifications.key.*',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image' => 'nullable|integer|min:0'
        ]);

        \DB::beginTransaction();

        try {
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
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('public/product_images');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => str_replace('public/', '', $path),
                        'is_main' => $index == $validated['main_image'],
                    ]);
                }
            }

            // Update the main image
            if ($request->has('main_image')) {
                foreach ($product->images as $index => $img) {
                    $img->is_main = ($index == $validated['main_image']);
                    $img->save();
                }
            }

            \DB::commit();

            return redirect()->route('employee.products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
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

