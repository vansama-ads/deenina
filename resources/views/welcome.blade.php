@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h4 class="mb-4">Daftar Chapter</h4>

    {{-- Alert --}}
    @include('layouts.alert')

    {{-- Search --}}
    <form action="{{ route('welcome') }}" method="GET" class="mb-4">
        <div class="input-group" style="max-width:720px;">
            <input
                type="text"
                name="search"
                placeholder="Cari Chapter"
                value="{{ $search ?? '' }}"
                class="form-control"
            >
            <button class="btn btn-primary" type="submit">
                Cari
            </button>
        </div>
    </form>

    {{-- No result --}}
    @if ($dishes->isEmpty())
        <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
            <div>
                <strong>Tidak ditemukan!</strong>
                <div>Coba kata kunci lain.</div>
            </div>
            <button type="button"
                    class="btn-close"
                    aria-label="Close"
                    onclick="this.parentElement.remove()">
            </button>
        </div>
    @endif

    {{-- Dish Cards --}}
    <div class="row g-4">
        @foreach ($dishes as $dish)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    @if ($dish->image)
                        <img src="{{ asset('storage/' . $dish->image) }}"
                             class="card-img-top img-fluid"
                             alt="{{ $dish->name }}">
                    @else
                        <img src="https://via.placeholder.com/400x600?text=No+Image"
                             class="card-img-top img-fluid"
                             alt="No Image">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $dish->name }}</h5>

                        <p class="card-text text-muted mb-2">
                            Kategori: {{ $dish->category->name ?? '-' }}
                        </p>

                        <p class="card-text mb-2">
                            Rp {{ number_format($dish->price, 0, ',', '.') }}
                        </p>

                        <p class="card-text mb-3">
                            {{ \Illuminate\Support\Str::limit($dish->description, 80) }}
                        </p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span>
                                @if($dish->is_available)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </span>

                            <a href="{{ route('dishes.showuser', $dish->id) }}"
                               class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
