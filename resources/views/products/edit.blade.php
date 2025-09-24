@extends('layouts.app')

@section('content')


    <div class="container">
        <h1>Chỉnh Sửa Sản Phẩm: {{ $product->title }}</h1>

        @if ($errors->any())
            <div>
                <strong>Lỗi:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="form-group">
                <label for="title">Tiêu đề:</label>
                <input type="text" id="title" name="title" value="{{ old('title', $product->title) }}" required>
                @error('title') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="releaseDate">Ngày phát hành:</label>
                <input type="date" id="releaseDate" name="releaseDate" value="{{ old('releaseDate', $product->releaseDate->format('Y-m-d')) }}" required>
                @error('releaseDate') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="developer">Nhà phát triển:</label>
                <input type="text" id="developer" name="developer" value="{{ old('developer', $product->developer) }}" required>
                @error('developer') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="publisher">Nhà xuất bản:</label>
                <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $product->publisher) }}" required>
                @error('publisher') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="content">Nội dung:</label>
                <textarea id="content" name="content">{{ old('content', $product->content) }}</textarea>
                @error('content') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="price">Giá</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </form>
    </div>

@endsection