@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Hobby Details</h1>
        <p><strong>ID:</strong> {{ $hobbies->id }}</p>
        <p><strong>Name:</strong> {{ $hobbies->name }}</p>
        <a href="{{ route('hobbies.index') }}" class="btn btn-primary">Back</a>
    </div>
@endsection
