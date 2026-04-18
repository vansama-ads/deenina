@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row mb-4">
        <div class="col-md-10">
            <h2>Edit Quiz</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST" id="quizForm">
                @csrf
                @method('PUT')

                <!-- Lesson Selection -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="lesson_id" class="form-label">Pilih Lesson <span class="text-danger">*</span></label>
                            <select name="lesson_id" id="lesson_id" class="form-select @error('lesson_id') is-invalid @enderror">
                                <option value="">-- Pilih Lesson --</option>
                                @foreach ($lessons as $lesson)
                                    <option value="{{ $lesson->id }}" @selected(old('lesson_id', $quiz->lesson_id) == $lesson->id)>
                                        {{ $lesson->act->title }} - {{ Str::limit($lesson->content, 40) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lesson_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Questions Container -->
                <div id="questionsContainer">
                    @foreach ($quiz->questions as $qIndex => $question)
                    <div class="card mb-3 question-card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Soal {{ $qIndex + 1 }}</h5>
                                @if ($qIndex > 0)
                                <button type="button" class="btn btn-sm btn-danger btn-remove-question">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                                <textarea name="questions[{{ $qIndex }}][question]" class="form-control question-text" rows="3" placeholder="Masukkan pertanyaan">{{ old("questions.$qIndex.question", $question->question) }}</textarea>
                            </div>

                            <h6 class="mb-3">Opsi Jawaban (minimal 4)</h6>

                            <div class="options-container">
                                @foreach ($question->options as $oIndex => $option)
                                <div class="mb-3 option-group">
                                    <div class="input-group">
                                        <input type="text" name="questions[{{ $qIndex }}][options][]" class="form-control" placeholder="Opsi" value="{{ old("questions.$qIndex.options.$oIndex", $option->option_text) }}">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 option-correct" type="radio" name="questions[{{ $qIndex }}][correct]" value="{{ $oIndex }}" @checked($option->is_correct)>
                                            @if ($oIndex > 3)
                                            <button type="button" class="btn btn-sm btn-danger ms-2 btn-remove-option"><i class="bi bi-trash"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-sm btn-secondary btn-add-option">
                                <i class="bi bi-plus-circle"></i> Tambah Opsi
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" id="btnAddQuestion">
                        <i class="bi bi-plus-circle"></i> Tambah Soal
                    </button>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Perbarui Quiz
                    </button>
                    <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionCount = {{ $quiz->questions->count() }};

    // Tambah Soal
    document.getElementById('btnAddQuestion').addEventListener('click', function() {
        const container = document.getElementById('questionsContainer');
        const newQuestion = `
            <div class="card mb-3 question-card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Soal ${questionCount + 1}</h5>
                        <button type="button" class="btn btn-sm btn-danger btn-remove-question">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                        <textarea name="questions[${questionCount}][question]" class="form-control question-text" rows="3" placeholder="Masukkan pertanyaan"></textarea>
                    </div>

                    <h6 class="mb-3">Opsi Jawaban (minimal 4)</h6>

                    <div class="options-container">
                        <div class="mb-3 option-group">
                            <div class="input-group">
                                <input type="text" name="questions[${questionCount}][options][]" class="form-control" placeholder="Opsi A">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0 option-correct" type="radio" name="questions[${questionCount}][correct]" value="0" checked>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 option-group">
                            <div class="input-group">
                                <input type="text" name="questions[${questionCount}][options][]" class="form-control" placeholder="Opsi B">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0 option-correct" type="radio" name="questions[${questionCount}][correct]" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 option-group">
                            <div class="input-group">
                                <input type="text" name="questions[${questionCount}][options][]" class="form-control" placeholder="Opsi C">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0 option-correct" type="radio" name="questions[${questionCount}][correct]" value="2">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 option-group">
                            <div class="input-group">
                                <input type="text" name="questions[${questionCount}][options][]" class="form-control" placeholder="Opsi D">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0 option-correct" type="radio" name="questions[${questionCount}][correct]" value="3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-secondary btn-add-option">
                        <i class="bi bi-plus-circle"></i> Tambah Opsi
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newQuestion);
        questionCount++;
        attachEventListeners();
    });

    function attachEventListeners() {
        // Hapus Soal
        document.querySelectorAll('.btn-remove-question').forEach(btn => {
            btn.addEventListener('click', function() {
                if (document.querySelectorAll('.question-card').length > 1) {
                    this.closest('.question-card').remove();
                } else {
                    alert('Minimal harus ada 1 soal!');
                }
            });
        });

        // Tambah Opsi
        document.querySelectorAll('.btn-add-option').forEach(btn => {
            btn.addEventListener('click', function() {
                const container = this.closest('.card-body').querySelector('.options-container');
                const questionCard = this.closest('.question-card');
                const qIndex = Array.from(document.querySelectorAll('.question-card')).indexOf(questionCard);
                const optionCount = container.querySelectorAll('.option-group').length;

                const newOption = `
                    <div class="mb-3 option-group">
                        <div class="input-group">
                            <input type="text" name="questions[${qIndex}][options][]" class="form-control" placeholder="Opsi">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0 option-correct" type="radio" name="questions[${qIndex}][correct]" value="${optionCount}">
                                <button type="button" class="btn btn-sm btn-danger ms-2 btn-remove-option"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newOption);
                attachOptionListeners();
            });
        });

        // Hapus Opsi
        document.querySelectorAll('.btn-remove-option').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const container = this.closest('.options-container');
                if (container.querySelectorAll('.option-group').length > 4) {
                    this.closest('.option-group').remove();
                } else {
                    alert('Minimal harus ada 4 opsi!');
                }
            });
        });
    }

    function attachOptionListeners() {
        document.querySelectorAll('.btn-remove-option').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const container = this.closest('.options-container');
                if (container.querySelectorAll('.option-group').length > 4) {
                    this.closest('.option-group').remove();
                } else {
                    alert('Minimal harus ada 4 opsi!');
                }
            });
        });
    }

    attachEventListeners();
});
</script>
@endsection