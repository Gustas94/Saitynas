@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit City</h1>
        <form action="{{ route('cities.update', $cities->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $cities->name }}" required>
            </div>
            <div class="form-group mt-3">
                <label for="country_id">Country:</label>
                <select name="country_id" class="form-control" required>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ $cities->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
