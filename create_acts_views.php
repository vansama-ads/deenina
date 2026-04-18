<?php

$directory = __DIR__ . '/resources/views/acts';
if (!is_dir($directory)) {
    mkdir($directory, 0755, true);
}

$files = [
    'index' => <<<'BLADE'
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Daftar Acts</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('acts.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Act
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (count($acts) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Act</th>
                        <th>Chapter</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($acts as $act)
                        <tr>
                            <td>{{ $act->id }}</td>
                            <td>
                                <strong>Act {{ $act->order_number }}:</strong> {{ $act->title }}
                            </td>
                            <td>{{ $act->chapter->title }}</td>
                            <td>{{ $act->order_number }}</td>
                            <td>
                                <a href="{{ route('acts.show', $act->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('acts.edit', $act->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('acts.destroy', $act->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $acts->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i> Belum ada data Act. <a href="{{ route('acts.create') }}">Tambah Act baru</a>
        </div>
    @endif
</div>
@endsection
BLADE,
    'create' => <<<'BLADE'
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Tambah Act Baru</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('acts.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="chapter_id" class="form-label">Chapter</label>
                            <select name="chapter_id" id="chapter_id" class="form-select @error('chapter_id') is-invalid @enderror">
                                <option value="">-- Pilih Chapter --</option>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}" @selected(old('chapter_id') == $chapter->id)>
                                        {{ $chapter->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('chapter_id')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Act</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" placeholder="Masukkan judul act">
                            @error('title')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order_number" class="form-label">Nomor Urut</label>
                            <input type="number" name="order_number" id="order_number" class="form-control @error('order_number') is-invalid @enderror" 
                                   value="{{ old('order_number') }}" placeholder="Masukkan nomor urut" min="1">
                            @error('order_number')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="{{ route('acts.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
BLADE,
    'edit' => <<<'BLADE'
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Edit Act</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('acts.update', $act->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="chapter_id" class="form-label">Chapter</label>
                            <select name="chapter_id" id="chapter_id" class="form-select @error('chapter_id') is-invalid @enderror">
                                <option value="">-- Pilih Chapter --</option>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}" @selected(old('chapter_id', $act->chapter_id) == $chapter->id)>
                                        {{ $chapter->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('chapter_id')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Act</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $act->title) }}" placeholder="Masukkan judul act">
                            @error('title')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order_number" class="form-label">Nomor Urut</label>
                            <input type="number" name="order_number" id="order_number" class="form-control @error('order_number') is-invalid @enderror" 
                                   value="{{ old('order_number', $act->order_number) }}" placeholder="Masukkan nomor urut" min="1">
                            @error('order_number')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Perbarui
                            </button>
                            <a href="{{ route('acts.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
BLADE,
    'show' => <<<'BLADE'
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Detail Act</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('acts.edit', $act->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('acts.index') }}" class="btn btn-secondary">
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
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Act</label>
                        <p class="form-control-plaintext">{{ $act->title }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Chapter</label>
                        <p class="form-control-plaintext">{{ $act->chapter->title }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor Urut</label>
                        <p class="form-control-plaintext">{{ $act->order_number }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Dibuat</label>
                        <p class="form-control-plaintext">{{ $act->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Diperbarui</label>
                        <p class="form-control-plaintext">{{ $act->updated_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <form action="{{ route('acts.destroy', $act->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus Act ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
BLADE,
];

foreach ($files as $name => $content) {
    file_put_contents("$directory/$name.blade.php", $content);
}

echo "✓ Acts views created successfully in " . $directory;
