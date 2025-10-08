@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Quản Lý Nền Tảng (Platforms)</h1>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-3">
                <p>{{ $message }}</p>
            </div>
        @endif

        <a href="{{ route('platforms.create') }}" class="btn btn-primary mb-3">Thêm Nền Tảng Mới</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Nền Tảng</th>
                    <th width="200px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($platforms as $platform)
                    <tr>
                        <td>{{ $platform->id }}</td>
                        <td>{{ $platform->name }}</td>
                        <td>
                            <form action="{{ route('platforms.destroy', $platform->id) }}" method="POST">
                                <a class="btn btn-primary btn-sm" href="{{ route('platforms.edit', $platform->id) }}">Sửa</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa nền tảng này không?');">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! $platforms->links() !!}
    </div>
@endsection