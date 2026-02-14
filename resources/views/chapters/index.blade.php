@extends('layouts.app')

@section('content')
<h4>List Chapters</h4>
<a href="{{ route('chapters.create') }}" class="btn btn-sm btn-primary">Add Chapters</a>
<br/><br />
<!-- Include Alert Messages -->
@include('layouts.alert')

<table class="table">
    <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Chapter ke-</th>
            <th scope="col">Description</th>
            
        </tr>
    </thead>
    <tbody>
        @forelse ($chapters as $chapter)
        <tr>
            <td>{{ $chapter->title }}</td>
            <td>{{ $chapter->order_number }}</td>
            <td>{{ $chapter->description }}</td>
            <td>
                <a href="{{ route('chapters.show',$chapter->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('chapters.edit',$chapter->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form onsubmit="return confirm('Apakah anda yakin ?');" action="{{ route('chapters.destroy',$chapter->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
                                    <div class="alert alert-info">
                                        data masih kosong.
                                    </div>
            @endforelse
    </tbody>
</table>
@endsection