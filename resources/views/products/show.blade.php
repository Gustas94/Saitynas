@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Product Details</h1>
    <div class="mb-4">
        <label class="block">Name:</label>
        <p>{{ $product->name }}</p>
    </div>
    <div class="mb-4">
        <label class="block">Category:</label>
        <p>{{ $product->category }}</p>
    </div>
    <div class="mb-4">
        <label class="block">Description:</label>
        <p>{{ $product->description }}</p>
    </div>
    <div class="mb-4">
        <label class="block">Specifications:</label>
        <p>{{ $product->specifications }}</p>
    </div>
    <div class="mb-4">
        <label class="block">Price:</label>
        <p>{{ $product->price }}</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
</div>
@endsection
