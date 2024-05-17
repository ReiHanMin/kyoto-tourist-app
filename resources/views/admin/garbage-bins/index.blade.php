@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Garbage Bins</h1>
        <a href="{{ route('admin.garbage-bins.create') }}" class="btn btn-primary">Add New Garbage Bin</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bins as $bin)
                    <tr>
                        <td>{{ $bin->id }}</td>
                        <td>{{ $bin->type }}</td>
                        <td>{{ $bin->latitude }}</td>
                        <td>{{ $bin->longitude }}</td>
                        <td>
                            <a href="{{ route('admin.garbage-bins.edit', $bin->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.garbage-bins.destroy', $bin->id) }}" method="POST" style="display:inline;">
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
