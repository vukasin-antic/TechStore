@extends('layouts.layout')

@section('Title', 'My Orders')

@section('content')

    @include('fixed.page-header', [
        'title' => 'My Orders',
        'breadcrumbs' => ['My Orders' => '#']
    ])

    <div class="container-fluid py-5">
        <div class="container py-5">
            @if($orders->count() > 0)
                <div class="accordion" id="ordersAccordion">
                    @foreach($orders as $order)
                        <div class="accordion-item border mb-3 rounded shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#order-{{ $order->id }}">
                                    <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                        <span class="fw-bold text-primary">{{ $order->order_number }}</span>
                                        <span class="text-muted small">{{ $order->created_at->format('d M Y') }}</span>

                                        <span class="fw-bold">{{ $order->total_price }} $</span>
                                        <span class="badge rounded-pill px-3 py-2
                                            {{ $order->status == 'pending' ? 'badge-pending' : '' }}
                                            {{ $order->status == 'processing' ? 'bg-info' : '' }}
                                            {{ $order->status == 'shipped' ? 'bg-primary' : '' }}
                                            {{ $order->status == 'delivered' ? 'badge-success' : '' }}
                                            {{ $order->status == 'cancelled' ? 'badge-cancelled' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="order-{{ $order->id }}" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <table class="table mb-3">
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
                                                <td>{{ $item->product?->name ?? 'Deleted product' }}
                                                    @if(!$item->product || $item->product->trashed())
                                                        <span class="badge bg-secondary ms-1">No longer available</span>
                                                    @endif</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->price }} $</td>
                                                <td>{{ $item->price * $item->quantity }} $</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Delivery Information</h6>
                                            <p class="mb-1 small">{{ $order->address }}, {{ $order->city }}, {{ $order->country }}</p>
                                            <p class="mb-1 small">Phone: {{ $order->phone_number }}</p>
                                            @if($order->notes)
                                                <p class="mb-1 small">Notes: {{ $order->notes }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-end">
                                            @if($order->discount)
                                                <p class="text-end text-success mb-3">Congrats you used our promo code 'ICT20' for discount: <strong>-20%</strong></p>
                                            @endif
                                            <h5 class="fw-bold text-primary">Total: {{ $order->total_price }} $</h5>
                                        </div>
                                    </div>
                                    @if($order->status === 'pending')
                                        <div class="text-end mt-2">
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3 btn-cancel-order"
                                                    data-id="{{ $order->id }}">
                                                <i class="fas fa-times me-1"></i> Cancel Order
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4>No orders yet!</h4>
                    <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection
@section('additional-scripts')
    <script>
        $(document).on('click', '.btn-cancel-order', function() {
            var orderId = $(this).data('id');
            var btn = $(this);

            showConfirm('Are you sure you want to cancel this order? This cannot be undone.', function() {
                $.ajax({
                    url: '/my-orders/' + orderId + '/cancel',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PATCH'
                    },
                    success: function(response) {
                        if (response.success) {
                            btn.closest('.accordion-item').find('.badge')
                                .removeClass('badge-pending bg-info bg-primary badge-success')
                                .addClass('badge-cancelled')
                                .text('Cancelled');
                            btn.closest('.text-end').remove();
                            showToast(response.message);
                        } else {
                            showToast(response.message, false);
                        }
                    }
                });
            }, {
                title: 'Cancel Order',
                icon: 'fa-times-circle text-danger',
                btnClass: 'btn-danger',
                btnText: 'Yes, Cancel Order'
            });
        });
    </script>
@endsection
