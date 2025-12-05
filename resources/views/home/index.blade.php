@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h1>Welcome to UniSellVie Store</h1>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <!-- Search Form -->
                <form action="{{ route('home.index') }}" method="GET" class="d-flex align-items-center mb-4">
                    <input class="form-control bg-dark border-0 me-2" type="text" name="search" placeholder="Search for product..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Display products as table -->
    <div class="row mt-3">
        <div class="col-12">
            <table class="table table-bordered table-dark table-hover">
                <thead>
                    <tr>
                        <th width="40%">Title</th>
                        <th width="15%">Released date</th>
                        <th width="20%">Developer</th>
                        <th width="15%">Price</th>
                        <th width="10%">Action</th>
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
                            <td>{{ number_format($product->price) }} VNĐ</td>
                            <td>
                                <!-- View button (detail) and purchase button (simulated) -->
                                <a href="{{ route('home.show', $product->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye me-0"></i> View
                                </a>
                                {{-- The purchase button will be displayed in show page --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">There is no product available in the store.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection