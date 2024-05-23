@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="form-group mt-3">
            <label for="category">Category:</label>
            <select name="category" class="form-control" required>
                <option value="phones" {{ $product->category == 'phones' ? 'selected' : '' }}>Phones</option>
                <option value="headphones" {{ $product->category == 'headphones' ? 'selected' : '' }}>Headphones</option>
                <option value="monitors" {{ $product->category == 'monitors' ? 'selected' : '' }}>Monitors</option>
                <!-- Add more categories as needed -->
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <div class="form-group mt-3">
            <label for="specifications">Specifications (JSON format):</label>
            <textarea name="specifications" class="form-control">{{ $product->specifications }}</textarea>
        </div>
        <div class="form-group mt-3">
            <label for="price">Price:</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required step="0.01">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
