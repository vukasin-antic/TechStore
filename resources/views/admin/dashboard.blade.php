@extends('admin.layouts.admin-layout')

@section('Title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $totalOrders }}</div>
                        <div class="stat-label">Total Orders
                            <small class="text-warning mx-5">{{ $pendingOrders }} pending</small>
                        </div>

                    </div>
                    <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $totalProducts }}</div>
                        <div class="stat-label">Total Products</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-box"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $totalUsers }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ number_format($totalRevenue, 2) }} $</div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="admin-table mb-4">
        <div class="table-header">
            <h5>Recent Orders</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm rounded-pill px-3">View All</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recentOrders as $order)
                <tr>
                    <td><span class="text-primary fw-bold">{{ $order->order_number }}</span></td>
                    <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>
                        <span class="badge rounded-pill px-3
                                    {{ $order->status == 'pending' ? 'badge-pending' : '' }}
                                    {{ $order->status == 'processing' ? 'bg-info' : '' }}
                                    {{ $order->status == 'shipped' ? 'bg-primary' : '' }}
                                    {{ $order->status == 'delivered' ? 'badge-success' : '' }}
                                    {{ $order->status == 'cancelled' ? 'badge-cancelled' : '' }}">
                                    {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->order_number }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No orders yet</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Logs -->
    <div class="admin-table">
        <div class="table-header">
            <h5>Recent Activity</h5>
            <a href="{{ route('admin.logs.index') }}" class="btn btn-primary btn-sm rounded-pill px-3">View All</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>User</th>
                <th>Route</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recentLogs as $log)
                <tr>
                    <td>{{ $log->user }}</td>
                    <td><span class="badge bg-secondary rounded-pill">{{ $log->route }}</span></td>
                    <td><small>{{ \Carbon\Carbon::parse($log->date)->format('d M H:i') }}</small></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No logs yet</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
