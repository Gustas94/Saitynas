@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Hobby</h1>
        <form action="{{ route('hobbies.update', $hobbies->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $hobbies->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
