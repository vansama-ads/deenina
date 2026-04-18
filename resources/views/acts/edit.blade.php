@extends('layouts.app')

@section('content')
<div class="py-4">
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
                            <label for="chapter_id" class="form-label">Chapter <span class="text-danger">*</span></label>
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
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Act <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $act->title) }}" 
                                   placeholder="Masukkan judul act">
                            @error('title')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order_number" class="form-label">Nomor Urut <span class="text-danger">*</span></label>
                            <input type="number" name="order_number" id="order_number" 
                                   class="form-control @error('order_number') is-invalid @enderror" 
                                   value="{{ old('order_number', $act->order_number) }}" 
                                   placeholder="Masukkan nomor urut" 
                                   min="1">
                            @error('order_number')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 mt-4">
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
