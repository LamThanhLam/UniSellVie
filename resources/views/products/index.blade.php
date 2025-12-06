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
                    <div class="row mb-4">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            
                            <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>

                            <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center">
                                
                                <input class="form-control bg-dark border-0 me-2" 
                                    type="text" 
                                    name="search" 
                                    placeholder="Search for product..." 
                                    value="{{ request('search') }}" 
                                    style="width: 250px;">
                                
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>    

        <div class="row mt-3">
            <div class="col-12">
                <table class="table table-bordered table-dark table-hover">
                    <thead>
                        <tr>
                            <th width="37%">Title</th>
                            <th width="12%">Released date</th>
                            <th width="20%">Developer</th>
                            <th width="8%">Price</th>
                            <th width="23%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>  
                                <td>
                                    <!-- link to published detail page -->
                                    <a href="{{ route('home.show', $product->id) }}">{{ $product->title }}</a>
                                </td>
                                <td>{{ $product->releaseDate->format('m/d/Y') }}</td>
                                <td>{{ $product->developer }}</td>
                                <td>{{ number_format($product->price) }} $</td>
                                <td>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye me-0"></i> View
                                    </a>
                                    @can('update', $product)
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-pen me-0"></i> Update</a>
                                    @endcan

                                    @can('delete', $product)
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">
                                                <i class="fa fa-trash me-0"></i> Delete</button>
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
            </div>
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>
    </div>
@endsection

