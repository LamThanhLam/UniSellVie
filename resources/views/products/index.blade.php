

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh Sách Sản Phẩm</h1>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="actions">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Thêm Sản Phẩm Mới</a>
            <form action="{{ route('products.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                <button type="submit">Tìm Kiếm</button>
            </form>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Ảnh</th> <th>Tiêu đề</th>
                    <th>Ngày phát hành</th>
                    <th>Nhà phát triển</th>
                    <th>Nhà xuất bản</th>
                    <th width="280px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                    <td> @if ($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" width="50px" height="50px" alt="Product image">
                        @else
                            <img src="{{ asset('images/default.png') }}" width="50px" height="50px" alt="No image">
                        @endif
                    </td>    
                    <td><a href="{{ route('products.show', $product->id) }}">{{ $product->title }}</a></td>
                        <td>{{ $product->releaseDate->format('d/m/Y') }}</td>
                        <td>{{ $product->developer }}</td>
                        <td>{{ $product->publisher }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}">{{ $product->title }}</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Sửa</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Không có sản phẩm nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $products->links() }}
        </div>
    </div>
@endsection

