@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Score Card -->
            <div class="card mb-4 @if($isPassed) border-success @else border-danger @endif">
                <div class="card-body text-center">
                    <h4 class="mb-3">
                        @if($isPassed)
                            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                            <p class="text-success mt-3">SELAMAT! ANDA LULUS</p>
                        @else
                            <i class="bi bi-x-circle text-danger" style="font-size: 3rem;"></i>
                            <p class="text-danger mt-3">COBA LAGI</p>
                        @endif
                    </h4>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <h6>Skor</h6>
                                <h2 class="text-primary">{{ $score }}/{{ $totalQuestions }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <h6>Persentase</h6>
                                <h2 class="@if($isPassed) text-success @else text-danger @endif">{{ $percentage }}%</h2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <h6>Passing Grade</h6>
                                <h2>70%</h2>
                            </div>
                        </div>
                    </div>

                    <div class="progress mb-4" style="height: 25px;">
                        <div class="progress-bar @if($isPassed) bg-success @else bg-danger @endif" 
                             role="progressbar" 
                             style="width: {{ $percentage }}%"
                             aria-valuenow="{{ $percentage }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            {{ $percentage }}%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Jawaban -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Detail Jawaban</h5>
                </div>
                <div class="card-body">
                    @foreach ($quiz->questions as $qIndex => $question)
                    <div class="mb-4 pb-3 @if(!$loop->last) border-bottom @endif">
                        <h6 class="mb-3">
                            <span class="badge @if($answers[$qIndex]['is_correct']) bg-success @else bg-danger @endif">
                                Soal {{ $qIndex + 1 }}
                            </span>
                            @if($answers[$qIndex]['is_correct'])
                                <span class="text-success"><i class="bi bi-check-circle"></i> Benar</span>
                            @else
                                <span class="text-danger"><i class="bi bi-x-circle"></i> Salah</span>
                            @endif
                        </h6>

                        <p class="mb-2"><strong>Pertanyaan:</strong> {{ $question->question }}</p>

                        <div class="ms-3 mb-3">
                            <p class="mb-2"><strong>Pilihan Anda:</strong></p>
                            @php
                                $selectedOption = null;
                                foreach ($question->options as $option) {
                                    if ($option->id == $answers[$qIndex]['option_id']) {
                                        $selectedOption = $option;
                                        break;
                                    }
                                }
                            @endphp

                            @if ($selectedOption)
                                <div class="alert @if($answers[$qIndex]['is_correct']) alert-success @else alert-danger @endif">
                                    {{ $selectedOption->option_text }}
                                </div>
                            @else
                                <div class="alert alert-warning">Tidak dijawab</div>
                            @endif

                            @if (!$answers[$qIndex]['is_correct'])
                                <p class="mb-2"><strong>Jawaban Benar:</strong></p>
                                @foreach ($question->options as $option)
                                    @if ($option->is_correct)
                                    <div class="alert alert-success">
                                        {{ $option->option_text }}
                                    </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 justify-content-center">
                @if (!$isPassed)
                <a href="{{ route('quiz.reset', $quiz->id) }}" class="btn btn-warning btn-lg">
                    <i class="bi bi-arrow-clockwise"></i> Coba Lagi
                </a>
                @endif

                <a href="{{ route('lessons.show', $quiz->lesson_id) }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left"></i> Kembali ke Lesson
                </a>
            </div>
        </div>
    </div>
</div>
@endsection