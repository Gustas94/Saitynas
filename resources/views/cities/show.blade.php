@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>City Details</h1>
        <p><strong>ID:</strong> {{ $cities->id }}</p>
        <p><strong>Name:</strong> {{ $cities->name }}</p>
        <p><strong>Country:</strong> {{ $cities->country->name }}</p>
        <a href="{{ route('cities.index') }}" class="btn btn-primary">Back</a>
    </div>
@endsection
