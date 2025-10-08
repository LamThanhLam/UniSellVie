@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thêm Nền Tảng Mới</h1>

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

        <form action="{{ route('platforms.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Tên Nền Tảng:</label>
                <input type="text" name="name" class="form-control" placeholder="Ví dụ: Windows, macOS..." required>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Thêm</button>
            <a class="btn btn-secondary mt-3" href="{{ route('platforms.index') }}">Quay lại</a>
        </form>
    </div>
@endsection