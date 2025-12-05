@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h1>Platforms Management</h1>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-3">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <a href="{{ route('platforms.create') }}" class="btn btn-primary mb-3">Add new platform</a>
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
                            <th width="30%">Platform name</th>
                            <th width="62%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($platforms as $platform)
                            <tr>
                                <td>{{ $platform->id }}</td>
                                <td>{{ $platform->name }}</td>
                                <td>
                                    <form action="{{ route('platforms.destroy', $platform->id) }}" method="POST">
                                        <a class="btn btn-info btn-sm" href="{{ route('platforms.edit', $platform->id) }}">
                                            <i class="fa fa-pen me-0"></i> Update</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this platform?');"><i class="fa fa-trash me-0"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {!! $platforms->links() !!}
    </div>
@endsection