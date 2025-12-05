@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h1 class="mb-4">Add New Platform</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Error!</strong> Please check the input information again.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('platforms.store') }}" method="POST">
                    @csrf

                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="name">Platform name:</label>
                            <input type="text" name="name" class="form-control bg-dark border-0" placeholder="Example: Windows, macOS..." required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-4">Add</button>
                        <a class="btn btn-secondary mt-4" href="{{ route('platforms.index') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection