@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h1>Your Order History</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row mt-3">
        <div class="col-12">
            @if ($orders->isEmpty())
                <div class="alert alert-info">You have no orders yet.</div>
            @else
                <table class="table table-bordered table-dark table-hover">
                    <thead>
                        <tr>
                            <th width="30%">Order Code</th>
                            <th width="12%">Total amount</th>
                            <th width="20%">Status</th>
                            <th width="15%">Order date</th>
                            <th width="23%">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ number_format($order->total_amount) }} $</td>
                                <td>
                                    @if ($order->status == 'Paid')
                                        <span class="badge bg-success">{{ $order->status }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('m/d/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye me-0"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    
    <a href="{{ route('home.index') }}" class="btn btn-secondary mt-3">Continue To Browse</a>
</div>
@endsection