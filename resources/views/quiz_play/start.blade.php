@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Siap untuk Mulai Quiz?</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <h2>{{ $lesson->act->title }}</h2>
                        <p class="text-muted">{{ Str::limit($lesson->content, 100) }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <h6>Jumlah Soal</h6>
                                <h3 class="text-primary">{{ $totalQuestions }}</h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <h6>Passing Grade</h6>
                                <h3 class="text-success">70%</h3>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Informasi:</strong> Anda akan mengerjakan {{ $totalQuestions }} soal. 
                        Setiap soal harus dijawab sebelum melanjutkan ke soal berikutnya.
                    </div>

                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <a href="{{ route('quiz.play', $quiz->id) }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-play-circle"></i> Mulai Quiz
                        </a>
                        <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection