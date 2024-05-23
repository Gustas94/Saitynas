@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Country</h1>
        <form action="{{ route('countries.update', $countries->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $countries->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
