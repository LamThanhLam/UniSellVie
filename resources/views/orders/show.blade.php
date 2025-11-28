@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Chi tiết Đơn hàng #{{ $order->id }}</h1>
        <h4>Trạng thái: 
            @if ($order->status == 'Paid')
                <span class="badge bg-success">{{ $order->status }}</span>
            @else
                <span class="badge bg-warning text-dark">{{ $order->status }}</span>
            @endif
        </h4>
    </div>
    
    <hr>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Phương thức Thanh toán:</strong> {{ $order->payment_method }}</p>
            <p><strong>Người mua:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
        </div>
    </div>
    
    <h2 class="mt-4">Sản phẩm đã mua:</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên Game</th>
                <th>Giá tại thời điểm mua</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->title }}</td>
                    <td>{{ number_format($item->price) }} VNĐ</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                <td><strong>{{ number_format($order->total_amount) }} VNĐ</strong></td>
            </tr>
        </tfoot>
    </table>
    
    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Quay lại Lịch sử Đơn hàng</a>
</div>
@endsection