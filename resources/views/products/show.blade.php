@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thông Tin Chi Tiết Sản Phẩm</h1>
        <div class="card">
            <div class="card-header">
                {{ $product->title }}
            </div>
            <div class="card-body">
                <p><strong>Ngày phát hành:</strong> {{ $product->releaseDate->format('d/m/Y') }}</p>
                <p><strong>Nhà phát triển:</strong> {{ $product->developer }}</p>
                <p><strong>Nhà xuất bản:</strong> {{ $product->publisher }}</p>
                <p><strong>Giá:</strong> {{ number_format($product->price, 2) }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Sửa</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
@endsection