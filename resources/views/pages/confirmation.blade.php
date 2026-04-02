@extends('layouts.layout')

@section('Title', 'Order Confirmed')

@section('content')

    @include('fixed.page-header', [
        'title' => 'Order Confirmed',
        'breadcrumbs' => ['Order Confirmation' => '#']
    ])

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                <h2 class="fw-bold mt-3">Thank you for your order!</h2>
                <p class="text-muted">Your order has been placed successfully.</p>
                <h5 class="text-primary">Order #{{ $order->order_number }}</h5>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Order Details</h5>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price }} $</td>
                                        <td>{{ $item->price * $item->quantity }} $</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                @if($order->discount)
                                    <tr>
                                        <td colspan="3" class="fw-bold text-end text-success">Congrats you used our promo code 'ICT20' for discount:</td>
                                        <td class="fw-bold text-success">-20%</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="fw-bold text-end">Total:</td>
                                    <td class="fw-bold text-primary">{{ $order->total_price }} $</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Delivery Information</h5>
                            <p class="mb-1"><strong>Name:</strong> {{ $order->first_name ?? session('user')['first_name'] }} {{ $order->last_name ?? session('user')['last_name'] }}</p>
                            <p class="mb-1"><strong>Address:</strong> {{ $order->address }}</p>
                            <p class="mb-1"><strong>City:</strong> {{ $order->city }}</p>
                            <p class="mb-1"><strong>Country:</strong> {{ $order->country }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $order->phone_number }}</p>
                            @if($order->notes)
                                <p class="mb-1"><strong>Notes:</strong> {{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-5 py-3">
                            <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary rounded-pill px-5 py-3 ms-3">
                            <i class="fas fa-list me-2"></i> My Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
