@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h1>Genre Management</h1>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-3">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <a href="{{ route('genres.create') }}" class="btn btn-primary mb-3">Add new genre</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <table class="table table-bordered table-dark table-hover">
                    <thead>
                        <tr>
                            <th width="8%">ID</th>
                            <th width="30%">Name Of Genre</th>
                            <th width="62%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($genres as $genre)
                            <tr>
                                <td>{{ $genre->id }}</td>
                                <td>{{ $genre->name }}</td>
                                <td>
                                    <form action="{{ route('genres.destroy', $genre->id) }}" method="POST">
                                        <a class="btn btn-info btn-sm" href="{{ route('genres.edit', $genre->id) }}">
                                            <i class="fa fa-pen me-0"></i> Update</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this genre?');"><i class="fa fa-trash me-0"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {!! $genres->links() !!}
    </div>
@endsection