@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Garbage Bin</h1>
        <form action="{{ route('admin.garbage-bins.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="General Waste">General Waste</option>
                    <option value="Recyclables">Recyclables</option>
                    <option value="Organic Waste">Organic Waste</option>
                    <option value="Hazardous Waste">Hazardous Waste</option>
                    <option value="Plastic Only">Plastic Only</option>
                    <option value="Glass Only">Glass Only</option>
                    <option value="Paper Only">Paper Only</option>
                </select>
            </div>
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="number" step="any" class="form-control" id="latitude" name="latitude" required>
            </div>
            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="number" step="any" class="form-control" id="longitude" name="longitude" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
