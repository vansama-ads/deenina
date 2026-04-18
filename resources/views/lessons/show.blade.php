@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Detail Lesson</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('lessons.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Lesson untuk: {{ $lesson->act->title }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">ID</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">{{ $lesson->id }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Act</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">
                                <span class="badge bg-info">Act {{ $lesson->act->order_number }}: {{ $lesson->act->title }}</span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Content</label>
                        </div>
                        <div class="col-md-9">
                            <div class="bg-light p-3 rounded border">
                                {!! nl2br(e($lesson->content)) !!}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Dibuat</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">{{ $lesson->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Diperbarui</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">{{ $lesson->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus Lesson ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('lessons.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
