@extends('layouts.app')

@section('content')
<div class="py-4">
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
                        <th style="width: 60px;">No</th>
                        <th>Title</th>
                        <th>Chapter</th>
                        <th style="width: 120px;">Order Number</th>
                        <th style="width: 200px;">Actions</th>
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
                            <td><span class="badge bg-info">{{ $act->order_number }}</span></td>
                            <td>
                                <a href="{{ route('acts.show', $act->id) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('acts.edit', $act->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('acts.destroy', $act->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Yakin ingin menghapus?')">
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
            {{ $acts->links() }}
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
            <p class="mt-2">Belum ada data Act.</p>
            <a href="{{ route('acts.create') }}" class="btn btn-primary">Tambah Act Baru</a>
        </div>
    @endif
</div>
@endsection