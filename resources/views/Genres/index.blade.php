@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Genre Management (Genres)</h1>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-3">
                <p>{{ $message }}</p>
            </div>
        @endif

        <a href="{{ route('genres.create') }}" class="btn btn-primary mb-3">Add new genre</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name Of Genre</th>
                    <th width="200px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genres as $genre)
                    <tr>
                        <td>{{ $genre->id }}</td>
                        <td>{{ $genre->name }}</td>
                        <td>
                            <form action="{{ route('genres.destroy', $genre->id) }}" method="POST">
                                <a class="btn btn-primary btn-sm" href="{{ route('genres.edit', $genre->id) }}">Sửa</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this genre?');">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! $genres->links() !!}
    </div>
@endsection