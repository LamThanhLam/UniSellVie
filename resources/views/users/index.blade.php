@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">User Role Management</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-dark">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Current role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->role == 1) <span class="badge bg-danger">Admin</span>
                    @elseif ($user->role == 2) <span class="badge bg-warning text-dark">Seller</span>
                    @else <span class="badge bg-success">Customer</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('users.update_role', $user->id) }}" method="POST" style="display:flex; gap:5px;">
                        @csrf
                        <select name="role" class="form-select form-select-sm bg-secondary text-white" style="width: 120px;">
                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Seller</option>
                            <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Customer</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-info">Update</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection