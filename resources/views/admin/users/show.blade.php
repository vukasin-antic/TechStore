@extends('admin.layouts.admin-layout')

@section('Title', 'User Details')
@section('page-title', 'User Details')

@section('content')

    <div class="admin-table mb-4">
        <div class="p-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="admin-table">
                        <div class="table-header">
                            <h5>User Info</h5>
                        </div>
                        <div class="p-4">
                            <div class="text-center mb-4">
                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                     style="width:80px; height:80px; font-size:32px; color:white;">
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                </div>
                                <h5 class="fw-bold">{{ $user->first_name }} {{ $user->last_name }}</h5>
                                <span class="badge rounded-pill px-3 {{ $user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="mb-2"><strong>Joined:</strong> {{ $user->created_at->format('d M Y') }}</p>
                            <p class="mb-0"><strong>Total Orders:</strong> {{ $user->orders->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="btn btn-warning rounded-pill w-100">
                            <i class="fas fa-edit me-2"></i>Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-outline-secondary rounded-pill w-100">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="admin-table">
                        <div class="table-header">
                            <h5>Order History</h5>
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Order #</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($user->orders as $order)
                                <tr>
                                    <td class="text-center"><span class="text-primary fw-bold">{{ $order->order_number }}</span></td>
                                    <td class="text-center">{{ $order->orderItems->count() }}</td>
                                    <td class="text-center">{{ $order->total_price }} $</td>
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
                                           class="btn btn-sm btn-info rounded-pill">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No orders yet</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
