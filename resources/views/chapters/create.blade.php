@extends('layouts.app')

@section('content')
<h4>Create Chapter</h4>
<div class="container mt-5 mb-5">
    <form action="{{ route('chapters.store') }}" method="POST">
    @csrf
    <div class="form-group mb-3">
        <label for="title">Judul</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" >
     <!-- tampilkan pesan error -->
     @error('title')
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
        @enderror
    </div>
        <div class="form-group mb-3">
        <label for="order_number">Chapter ke-</label>
        <textarea name="order_number" id="order_number" class="form-control">{{ old('order_number') }}</textarea>
    </div>
    <div class="form-group mb-3">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
    </div>
    <button type="submit" class="btn btn-md btn-primary me-3">Save</button>
     <button type="reset" class="btn btn-md btn-primary me-3">Reset</button>
</form>
</div>
@endsection