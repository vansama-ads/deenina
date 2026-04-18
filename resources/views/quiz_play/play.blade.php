@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="mb-0">Soal {{ $currentNumber }} dari {{ $totalQuestions }}</h6>
                    <small class="text-muted">{{ round(($currentNumber / $totalQuestions) * 100) }}%</small>
                </div>
                <div class="progress" style="height: 25px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                         role="progressbar" 
                         style="width: {{ ($currentNumber / $totalQuestions) * 100 }}%"
                         aria-valuenow="{{ $currentNumber }}" 
                         aria-valuemin="0" 
                         aria-valuemax="{{ $totalQuestions }}">
                        {{ round(($currentNumber / $totalQuestions) * 100) }}%
                    </div>
                </div>
            </div>

            <!-- Question Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <span class="badge bg-primary">Soal {{ $currentNumber }}</span>
                    </h5>

                    <h6 class="mb-4 question-text">{{ $currentQuestion->question }}</h6>

                    <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
                        @csrf

                        <div class="question-options mb-4">
                            @foreach ($currentQuestion->options as $index => $option)
                            <div class="form-check option-item mb-3">
                                <input class="form-check-input" type="radio" name="answer" 
                                       id="option{{ $index }}" value="{{ $option->id }}" required>
                                <label class="form-check-label w-100" for="option{{ $index }}">
                                    <span class="option-letter">{{ chr(65 + $index) }}</span>
                                    <span class="option-text">{{ $option->option_text }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <input type="hidden" name="current_index" value="{{ $currentIndex }}">

                        <div class="d-flex gap-2 justify-content-end">
                            @if ($currentNumber > 1)
                            <a href="{{ route('quiz.reset', $quiz->id) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batalkan
                            </a>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                @if ($currentNumber < $totalQuestions)
                                    <i class="bi bi-arrow-right"></i> Soal Berikutnya
                                @else
                                    <i class="bi bi-check-circle"></i> Selesai
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.option-item {
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.option-item:hover {
    border-color: #007bff;
    background-color: #f8f9ff;
}

.form-check-input:checked ~ label {
    font-weight: 600;
}

.option-letter {
    display: inline-block;
    min-width: 30px;
    padding: 4px 8px;
    background-color: #e0e0e0;
    border-radius: 4px;
    margin-right: 10px;
    font-weight: 600;
}

.form-check-input:checked ~ label .option-letter {
    background-color: #007bff;
    color: white;
}

.question-text {
    color: #333;
    line-height: 1.6;
    font-size: 16px;
}
</style>
@endsection