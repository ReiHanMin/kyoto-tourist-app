@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Garbage Bin</h1>
        <form action="{{ route('admin.garbage-bins.update', $garbageBin->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="General Waste" {{ $garbageBin->type == 'General Waste' ? 'selected' : '' }}>General Waste</option>
                    <option value="Recyclables" {{ $garbageBin->type == 'Recyclables' ? 'selected' : '' }}>Recyclables</option>
                    <option value="Organic Waste" {{ $garbageBin->type == 'Organic Waste' ? 'selected' : '' }}>Organic Waste</option>
                    <option value="Hazardous Waste" {{ $garbageBin->type == 'Hazardous Waste' ? 'selected' : '' }}>Hazardous Waste</option>
                    <option value="Plastic Only" {{ $garbageBin->type == 'Plastic Only' ? 'selected' : '' }}>Plastic Only</option>
                    <option value="Glass Only" {{ $garbageBin->type == 'Glass Only' ? 'selected' : '' }}>Glass Only</option>
                    <option value="Paper Only" {{ $garbageBin->type == 'Paper Only' ? 'selected' : '' }}>Paper Only</option>
                </select>
            </div>
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="number" step="any" class="form-control" id="latitude" name="latitude" value="{{ $garbageBin->latitude }}" required>
            </div>
            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="number" step="any" class="form-control" id="longitude" name="longitude" value="{{ $garbageBin->longitude }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
