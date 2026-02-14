@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h4 class="mb-3">Chapter Details</h4>

    <!-- Include Alert Messages -->
    @include('layouts.alert')

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $chapter->name }}</h5>
                    <p class="card-text">Chapter ke{{ $chapter->order_number }}</p>
                    <hr>
                    <p class="card-text">{{ $chapter->description ?? '-' }}</p>

                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('chapters.index') }}" class="btn btn-sm btn-secondary">Back</a>
                        <a href="{{ route('chapters.edit', $chapter->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('chapters.destroy', $chapter->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-muted small">
                <span>Created: {{ $chapter->created_at ? \Carbon\Carbon::parse($chapter->created_at)->diffForHumans() : '-' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection