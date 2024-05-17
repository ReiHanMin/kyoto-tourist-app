@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Garbage Bin</h1>
        <form action="{{ route('admin.garbage-bins.update', $bin->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="General Waste" {{ $bin->type == 'General Waste' ? 'selected' : '' }}>General Waste</option>
                    <option value="Recyclables" {{ $bin->type == 'Recyclables' ? 'selected' : '' }}>Recyclables</option>
                    <option value="Organic Waste" {{ $bin->type == 'Organic Waste' ? 'selected' : '' }}>Organic Waste</option>
                    <option value="Hazardous Waste" {{ $bin->type == 'Hazardous Waste' ? 'selected' : '' }}>Hazardous Waste</option>
                    <option value="Plastic Only" {{ $bin->type == 'Plastic Only' ? 'selected' : '' }}>Plastic Only</option>
                    <option value="Glass Only" {{ $bin->type == 'Glass Only' ? 'selected' : '' }}>Glass Only</option>
                    <option value="Paper Only" {{ $bin->type == 'Paper Only' ? 'selected' : '' }}>Paper Only</option>
                </select>
            </div>
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="number" step="any" class="form-control" id="latitude" name="latitude" value="{{ $bin->latitude }}" required>
            </div>
            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="number" step="any" class="form-control" id="longitude" name="longitude" value="{{ $bin->longitude }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
