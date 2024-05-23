@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Hobbies</h1>
        <a href="{{ route('hobbies.create') }}" class="btn btn-primary">Add Hobby</a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hobbies as $hobby)
                <tr>
                    <td>{{ $hobby->id }}</td>
                    <td>{{ $hobby->name }}</td>
                    <td>
                        <a href="{{ route('hobbies.show', $hobby->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('hobbies.edit', $hobby->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('hobbies.destroy', $hobby->id) }}" method="POST" style="display:inline;">
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
