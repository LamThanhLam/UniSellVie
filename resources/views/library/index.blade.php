@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Thư viện Game của bạn</h1>
    <hr>

    @if ($libraryItems->isEmpty())
        <div class="alert alert-info text-center">
            Thư viện của bạn đang trống! Hãy quay lại trang cửa hàng để mua game.
            <br>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Đến Cửa hàng</a>
        </div>
    @else
        <div class="row">
            @foreach ($libraryItems as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card bg-dark text-white h-100 shadow">
                    <div class="card-body">
                        <h5 class="card-title text-warning">{{ $item->product->title }}</h5>
                        <p class="card-text">
                            Đã mua vào: {{ $item->created_at->format('d/m/Y') }}
                        </p>
                        <p class="card-text">
                            Phát triển bởi: {{ $item->product->developer }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        {{-- Đây là nơi bạn có thể thêm nút "Chơi Ngay" hoặc "Tải Xuống" --}}
                        <a href="{{ route('products.show', $item->product->id) }}" class="btn btn-sm btn-info">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $libraryItems->links() }}
        </div>
    @endif
</div>
@endsection