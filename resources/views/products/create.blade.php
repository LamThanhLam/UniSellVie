<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm Mới</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; }
        .container { max-width: 800px; margin: auto; }
        h1 { margin-bottom: 1rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.5rem; box-sizing: border-box; }
        .form-group textarea { resize: vertical; height: 100px; }
        .error { color: red; font-size: 0.875rem; }
        .btn { text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 4px; border: none; cursor: pointer; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; margin-left: 0.5rem; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-secondary:hover { background-color: #5a6268; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Thêm Sản Phẩm Mới</h1>

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

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Tiêu đề:</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                @error('title') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="releaseDate">Ngày phát hành:</label>
                <input type="date" id="releaseDate" name="releaseDate" value="{{ old('releaseDate') }}" required>
                @error('releaseDate') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="developer">Nhà phát triển:</label>
                <input type="text" id="developer" name="developer" value="{{ old('developer') }}" required>
                @error('developer') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="publisher">Nhà xuất bản:</label>
                <input type="text" id="publisher" name="publisher" value="{{ old('publisher') }}" required>
                @error('publisher') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="platform">Nền tảng</label>
                <input type="text" name="platform" id="platform" class="form-control">
            </div>
            <div class="form-group">
                <label for="genre">Thể loại</label>
                <input type="text" name="genre" id="genre" class="form-control">
            </div>
            <div class="form-group">
                <label for="content">Giới thiệu chi tiết (About This Game)</label>
                <textarea name="content" id="content" class="form-control" rows="8">{{ $product->content ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label for="system_requirements">Yêu cầu cấu hình (System Requirements)</label>
                <textarea name="system_requirements" id="system_requirements" class="form-control" rows="4">{{ $product->system_requirements ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Giá</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </form>
    </div>

</body>
</html>