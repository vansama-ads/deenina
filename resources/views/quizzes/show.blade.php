@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row mb-4">
        <div class="col-md-10">
            <h2>Detail Quiz</h2>
        </div>
        <div class="col-md-2 text-end">
            <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('quizzes.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <!-- Lesson Info -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Quiz</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="fw-bold">Lesson:</label>
                        </div>
                        <div class="col-md-9">
                            <span class="badge bg-info">{{ $quiz->lesson->act->title }}</span>
                            <br>
                            <small class="text-muted">{{ $quiz->lesson->content }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="fw-bold">Jumlah Soal:</label>
                        </div>
                        <div class="col-md-9">
                            <span class="badge bg-success">{{ $quiz->questions->count() }} soal</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions -->
            @foreach ($quiz->questions as $qIndex => $question)
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Soal {{ $qIndex + 1 }} dari {{ $quiz->questions->count() }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Pertanyaan:</label>
                        <p>{{ $question->question }}</p>
                    </div>

                    <h6>Opsi Jawaban:</h6>
                    <div class="list-group">
                        @foreach ($question->options as $oIndex => $option)
                        <div class="list-group-item @if($option->is_correct) list-group-item-success @endif">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>
                                    {{ chr(65 + $oIndex) }}. {{ $option->option_text }}
                                </span>
                                @if ($option->is_correct)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Jawaban Benar
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus Quiz ini?')">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
                <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection