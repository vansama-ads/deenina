@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Edit Lesson</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('lessons.update', $lesson->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="act_id" class="form-label">Act <span class="text-danger">*</span></label>
                            <select name="act_id" id="act_id" class="form-select @error('act_id') is-invalid @enderror">
                                <option value="">-- Pilih Act --</option>
                                @foreach ($acts as $act)
                                    <option value="{{ $act->id }}" @selected(old('act_id', $lesson->act_id) == $act->id)>
                                        Act {{ $act->order_number }}: {{ $act->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('act_id')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" rows="8"
                                      class="form-control @error('content') is-invalid @enderror"
                                      placeholder="Masukkan konten lesson (minimal 10 karakter)">{{ old('content', $lesson->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Perbarui
                            </button>
                            <a href="{{ route('lessons.index') }}" class="btn btn-secondary">
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
