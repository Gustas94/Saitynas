@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Countries</h1>
        <a href="{{ route('countries.create') }}" class="btn btn-primary">Add Country</a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>
                    <td>{{ $country->name }}</td>
                    <td>
                        <a href="{{ route('countries.show', $country->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('countries.destroy', $country->id) }}" method="POST" style="display:inline;">
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
