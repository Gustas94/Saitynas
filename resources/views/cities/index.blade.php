@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Cities</h1>
        <a href="{{ route('cities.create') }}" class="btn btn-primary">Add City</a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cities as $city)
                <tr>
                    <td>{{ $city->id }}</td>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->country->name }}</td>
                    <td>
                        <a href="{{ route('cities.show', $city->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('cities.destroy', $city->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
