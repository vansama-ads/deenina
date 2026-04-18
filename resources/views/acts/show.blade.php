@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Detail Act</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('acts.edit', $act->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('acts.index') }}" class="btn btn-secondary btn-sm">
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
                    <h5 class="mb-0">Act {{ $act->order_number }}: {{ $act->title }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">ID</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">{{ $act->id }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Judul</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">{{ $act->title }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Chapter</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">
                                <span class="badge bg-info">{{ $act->chapter->title }}</span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Nomor Urut</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">
                                <span class="badge bg-success">{{ $act->order_number }}</span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Dibuat</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">{{ $act->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Diperbarui</label>
                        </div>
                        <div class="col-md-9">
                            <p class="form-control-plaintext">{{ $act->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('acts.edit', $act->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('acts.destroy', $act->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus Act ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('acts.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
