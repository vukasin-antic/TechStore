@extends('admin.layouts.admin-layout')

@section('Title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')

    <div class="container-fluid shop">
        <div class="container-fluid p-3">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="admin-table mb-4">
                        <div class="table-header">
                            <h5>Order {{ $order->order_number }}</h5>
                            <span class="badge rounded-pill px-3 py-2
                                {{ $order->status == 'pending' ? 'badge-pending' : '' }}
                                {{ $order->status == 'processing' ? 'bg-info' : '' }}
                                {{ $order->status == 'shipped' ? 'bg-primary' : '' }}
                                {{ $order->status == 'delivered' ? 'badge-success' : '' }}
                                {{ $order->status == 'cancelled' ? 'badge-cancelled' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product?->name ?? 'Deleted product' }}
                                        @if(!$item->product || $item->product->trashed())
                                            <span class="badge bg-secondary ms-1">No longer available</span>
                                        @endif</td>
                                    <td>{{ $item->price }} $</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price * $item->quantity }} $</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">
                                    @if($order->discount)
                                        Subtotal:<br>
                                        Discount (20%):<br>
                                    @endif
                                    Total:
                                </td>
                                <td class="fw-bold">
                                    @if($order->discount)
                                        {{ round($order->total_price / 0.8, 2) }} $<br>
                                        <span class="text-success">-{{ round($order->total_price / 0.8 * 0.2, 2) }} $</span><br>
                                    @endif
                                    <span class="text-primary">{{ $order->total_price }} $</span>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Customer & Delivery Info -->
                <div class="col-lg-4">
                    <div class="admin-table mb-4">
                        <div class="table-header">
                            <h5>Customer</h5>
                        </div>
                        <div class="p-4">
                            <p class="mb-1"><strong>First Name:</strong> {{ $order->user->first_name }}</p>
                            <p class="mb-1"><strong>Last Name:</strong> {{ $order->user->last_name }}</p>
                            <p class="mb-0"><strong>Email:</strong> {{ $order->user->email }}</p>
                        </div>
                    </div>

                    <div class="admin-table mb-4">
                        <div class="table-header">
                            <h5>Delivery Information</h5>
                        </div>
                        <div class="p-4">
                            <p class="mb-1"><strong>Address:</strong> {{ $order->address }}</p>
                            <p class="mb-1"><strong>City:</strong> {{ $order->city }}</p>
                            <p class="mb-1"><strong>Country:</strong> {{ $order->country }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $order->phone_number }}</p>
                            @if($order->notes)
                                <p class="mb-0"><strong>Notes:</strong> {{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="admin-table">
                        <div class="table-header">
                            <h5>Order Info</h5>
                        </div>
                        <div class="p-4">
                            <p class="mb-1"><strong>Order #:</strong> {{ $order->order_number }}</p>
                            <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                            <p class="mb-0"><strong>Discount:</strong>
                                @if($order->discount)
                                    <span class="text-success">Yes (20%)</span>
                                @else
                                    No
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                           class="btn btn-warning rounded-pill w-100">
                            <i class="fas fa-edit me-2"></i>Edit Order
                        </a>
                        <a href="{{ route('admin.orders.index') }}"
                           class="btn btn-outline-secondary rounded-pill w-100">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
