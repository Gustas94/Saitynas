@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Country Details</h1>
        <p><strong>ID:</strong> {{ $countries->id }}</p>
        <p><strong>Name:</strong> {{ $countries->name }}</p>
        <a href="{{ route('countries.index') }}" class="btn btn-primary">Back</a>
    </div>
@endsection
