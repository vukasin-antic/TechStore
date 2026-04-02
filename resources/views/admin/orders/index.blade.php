@extends('admin.layouts.admin-layout')

@section('Title', 'Orders')
@section('keywords', 'orders, admin, techstore')
@section('description', 'Manage and filter all customer orders in TechStore admin panel.')
@section('page-title', 'Orders')

@section('content')

    <div class="container-fluid shop">
        <div class="container-fluid p-3">
            <div class="d-flex mb-4">
                <h5 class="fw-bold mb-0">All Orders</h5>
            </div>
            <form action="{{ route('admin.orders.index') }}" method="GET" id="Admin-order">
                <div class="row g-3 justify-content-between my-3">
                    <div class="col-xxl-2 col-lg-4">
                        <div class="input-group">
                            <input type="search"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Search order number..."/>
                            <button type="submit" class="input-group-text p-3">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-lg-4">
                        <select name="status" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-order').submit()">
                        <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-xxl-2 col-lg-4">
                        <select name="discount" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-order').submit()">
                            <option value="">All Orders</option>
                            <option value="yes" {{ request('discount') == 'yes' ? 'selected' : '' }}>With Discount</option>
                            <option value="no" {{ request('discount') == 'no' ? 'selected' : '' }}>Without Discount</option>
                        </select>
                    </div>
                    <div class="col-xxl-2 col-lg-4">
                        <select name="sort" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-order').submit()">
                            <option value="">Oldest First</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                    <div class="col-xxl-2 col-lg-4">
                        <input type="date" name="date_from" class="form-control select-fixed"
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-xxl-2 col-lg-4">
                        <input type="date" name="date_to" class="form-control select-fixed"
                               value="{{ request('date_to') }}">
                    </div>
                    <div class="col-12 d-flex align-items-center">
                        @if(request()->hasAny(['search', 'status', 'discount', 'sort', 'date_from', 'date_to']))
                            <div class="mb-1">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="fas fa-times me-1"></i> Reset Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>

            <table class="inventory-table">
                <thead>
                <tr>
                    <th class="text-center">Order #</th>
                    <th class="text-center">Customer</th>
                    <th class="text-center">Items</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Discount</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="text-center"><span class="text-primary fw-bold">{{ $order->order_number }}</span></td>
                        <td class="text-center">{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                        <td class="text-center">{{ $order->orderItems->count() }}</td>
                        <td class="text-center">{{ $order->total_price }} $</td>
                        <td class="text-center">
                            @if($order->discount)
                                <span class="badge bg-success rounded-pill">20% off</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                        <span class="badge rounded-pill px-3 py-2
                            {{ $order->status == 'pending' ? 'badge-pending' : '' }}
                            {{ $order->status == 'processing' ? 'bg-info' : '' }}
                            {{ $order->status == 'shipped' ? 'bg-primary' : '' }}
                            {{ $order->status == 'delivered' ? 'badge-success' : '' }}
                            {{ $order->status == 'cancelled' ? 'badge-cancelled' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                        </td>
                        <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="btn btn-sm btn-info rounded-pill me-1">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.orders.edit', $order->id) }}"
                               class="btn btn-sm btn-warning rounded-pill me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger rounded-pill btn-delete-order"
                                    data-id="{{ $order->id }}"
                                    data-order_number=" {{ $order->order_number }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No orders found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="p-3">
                {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
@section('additional-scripts')
    <script>
        $(document).on('click', '.btn-delete-order', function() {
            var orderId = $(this).data('id');
            var order_number = $(this).data('order_number');
            var row = $(this).closest('tr');

            confirmDelete('Are you sure you want to delete order #' + order_number + '?', function() {
                $.ajax({
                    url: '/admin/orders/' + orderId,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                            showToast(response.message, true);
                        } else {
                            showToast(response.message, false);
                        }
                    }
                });
            });
        });
    </script>
@endsection
