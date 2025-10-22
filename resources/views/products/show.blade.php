@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thông Tin Chi Tiết Sản Phẩm</h1>
        <div class="row">
            <div class="col-md-4 mb-4">
                @if ($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->title }}">
                @else
                    <img src="{{ asset('images/default.png') }}" class="img-fluid rounded" alt="Không có ảnh">
                @endif
            </div>
            <div class="col-md-8">
                <h1>{{ $product->title }}</h1>
                <p><strong>Giá:</strong> {{ number_format($product->price) }} VNĐ</p>
                </div>
        </div>

        <hr>
        <div class="card">
            <!-- <div class="card-header">
                {{ $product->title }}
            </div> -->
            <div class="card-body">
                <p><strong>Ngày phát hành:</strong> {{ $product->releaseDate->format('d/m/Y') }}</p>
                <p><strong>Nhà phát triển:</strong> {{ $product->developer }}</p>
                <p><strong>Nhà xuất bản:</strong> {{ $product->publisher }}</p>
                <p><strong>Mô tả ngắn:</strong> {{ $product->description }}</p>

                {{-- Display Platforms --}}
                <p>
                    <strong>Nền tảng:</strong>
                    @if ($product->platforms->count())
                        @foreach ($product->platforms as $platform)
                            <span class="badge bg-secondary">{{ $platform->name }}</span>
                        @endforeach
                    @else
                        <span>Chưa có nền tảng nào được chỉ định.</span>
                    @endif
                </p>

                {{-- Display Genres --}}
                <p>
                    <strong>Thể loại:</strong>
                    @if ($product->genres->count())
                        @foreach ($product->genres as $genre)
                            <span class="badge bg-info">{{ $genre->name }}</span>
                        @endforeach
                    @else
                        <span>Chưa có thể loại nào được chỉ định.</span>
                    @endif
                </p>

                {{-- Display About This Game (Content) --}}
                <h2>Giới thiệu chi tiết (About This Game)</h2>
                <div>
                    {!! nl2br(e($product->content)) !!} {{-- Dùng nl2br để giữ định dạng xuống dòng --}}
                </div>

                {{-- Display system requirements --}}
                <h2>Yêu cầu Cấu hình (System Requirements)</h2>
                <div>
                    {!! nl2br(e($product->system_requirements)) !!}
                </div>
                <p><strong>Giá:</strong> {{ number_format($product->price, 2) }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Sửa</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
@endsection