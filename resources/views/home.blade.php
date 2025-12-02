@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h1>List Of Products</h1>
                
                @if(session('success'))
                    <div class="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form>
                    <div class="actions">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
                        <form action="{{ route('products.index') }}" method="GET" class="d-none d-md-flex ms-4 col-sm-4 col-form-label">
                            <input class="form-control bg-dark border-0" type="text" name="search" placeholder="Search for product..." value="{{ request('search') }}">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                </form>
            </div>
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
                            @can('update', $product)
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Sửa</a>
                            @endcan

                            @can('delete', $product)
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">Xóa</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">There is no product.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
