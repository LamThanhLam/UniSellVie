@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Giỏ hàng của bạn</h1> @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    </div>
    @endif

    @if ($cartItems->isEmpty())
        <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div> @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Sản phẩm</th> <th>Giá</th> <th>Hành động</th> </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>{{ number_format($item->product->price) }} VNĐ</td>
                        <td>
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?');">Xóa</button> </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card p-3">
            <h3>Total: {{ number_format($totalPrice) }} $</h3> <button class="btn btn-primary btn-lg mt-3">Checkout (This feature is just a simulation)</button> </div>
    @endif

    <div class="card p-3">
        <h3>Total: {{ number_format($totalPrice) }} $</h3>
        
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg mt-3">Checkout</button>
        </form>
    </div>
    
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Tiếp tục mua sắm</a> </div>
@endsection