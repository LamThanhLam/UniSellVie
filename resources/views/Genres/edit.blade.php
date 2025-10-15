@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chỉnh Sửa Thể Loại</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Lỗi!</strong> Vui lòng kiểm tra lại thông tin nhập.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('genres.update', $platform->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên Thể Loại:</label>
                <input type="text" name="name" value="{{ $genre->name }}" class="form-control" placeholder="Tên Thể Loại" required>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
            <a class="btn btn-secondary mt-3" href="{{ route('genres.index') }}">Quay lại</a>
        </form>
    </div>
@endsection