@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
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
                        </div>
                        <form action="{{ route('home.index') }}" method="GET" class="d-flex align-items-center mb-4">
                            <input class="form-control bg-dark border-0 me-2" type="text" name="search" placeholder="Search for product..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </form>
                </div>
            </div>
        </div>    

        <table class="table">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Ngày phát hành</th>
                    <th>Nhà phát triển</th>
                    <th>Nhà xuất bản</th>
                    <th width="280px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>  
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
@endsection

