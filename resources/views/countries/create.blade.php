@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Country</h1>
        <form action="{{ route('countries.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
@endsection
