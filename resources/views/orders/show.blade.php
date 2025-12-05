@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Details of Order #{{ $order->id }}</h1>
        <h4>Status: 
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
            <p><strong>Order date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Payment method:</strong> {{ $order->payment_method }}</p>
            <p><strong>Buyer:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
        </div>
    </div>
    
    <h2 class="mt-4">Purchased product:</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Game name</th>
                <th>Price at time of purchase</th>
                <th>Amount</th>
                <th>Total amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->title }}</td>
                    <td>{{ number_format($item->price) }} $</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity) }} $</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><strong>{{ number_format($order->total_amount) }} $</strong></td>
            </tr>
        </tfoot>
    </table>
    
    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Back to order histories</a>
</div>
@endsection