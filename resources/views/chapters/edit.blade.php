@extends('layouts.app')

@section('content')
<h4>Edit Chapter</h4>
<div class="container mt-5 mb-5">
    <form action="{{ route('chapters.update',$chapter->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="title">Judul</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title',$chapter->title) }}" >
     <!-- tampilkan pesan error -->
     @error('title')
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
        @enderror
    </div>
        <div class="form-group mb-3">
        <label for="order_number">Chapter ke-</label>
        <textarea name="order_number" id="order_number" class="form-control">{{ old('order_number',$chapter->order_number) }}</textarea>
    </div>
    <div class="form-group mb-3">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description',$chapter->description) }}</textarea>
    </div>
    <button type="submit" class="btn btn-md btn-primary me-3">Save</button>
    <a href="{{ route('chapters.index') }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
</div>
@endsection