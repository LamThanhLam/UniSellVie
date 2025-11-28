@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lịch sử Đơn hàng của bạn</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($orders->isEmpty())
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã Đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ number_format($order->total_amount) }} VNĐ</td>
                        <td>
                            @if ($order->status == 'Paid')
                                <span class="badge bg-success">{{ $order->status }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Xem</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Tiếp tục mua sắm</a>
</div>
@endsection