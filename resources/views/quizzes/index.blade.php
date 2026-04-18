@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Daftar Quizzes</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('quizzes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Buat Quiz
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (count($quizzes) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Lesson</th>
                        <th style="width: 100px;">Jumlah Soal</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz->id }}</td>
                            <td>
                                <span class="badge bg-info">{{ $quiz->lesson->act->title }}</span>
                                <br>
                                <small class="text-muted">{{ Str::limit($quiz->lesson->content, 40) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $quiz->questions->count() }} soal</span>
                            </td>
                            <td>
                                <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Yakin?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $quizzes->links() }}
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
            <p class="mt-2">Belum ada Quiz.</p>
            <a href="{{ route('quizzes.create') }}" class="btn btn-primary">Buat Quiz Baru</a>
        </div>
    @endif
</div>
@endsection