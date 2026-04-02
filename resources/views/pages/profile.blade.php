@extends('layouts.layout')

@section('Title', 'Profile')

@section('content')

    @include('fixed.page-header', [
        'title' => 'My Profile',
        'breadcrumbs' => ['Profile' => '#']
    ])

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-4">

                <!-- Left side - User info -->
                <div class="col-lg-4">
                    <!-- Profile Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                     style="width:80px; height:80px; font-size:32px; color:white;">
                                    {{ strtoupper(substr(session('user')['first_name'], 0, 1)) }}
                                </div>
                                <h5 class="fw-bold">{{ session('user')['first_name'] }} {{ session('user')['last_name'] }}</h5>
                                <p class="text-muted mb-0">{{ session('user')['email'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Update Profile Form -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Update Profile</h5>

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-warning">{{ $errors->first() }}</div>
                            @endif

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label fw-bold">First Name</label>
                                    <input type="text" name="first_name" class="form-control"
                                           value="{{ $user->first_name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                           value="{{ $user->last_name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ $user->email }}">
                                </div>
                                <button type="submit" class="btn btn-primary rounded-pill w-100">
                                    Update Profile
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Form -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Change Password</h5>
                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Current Password</label>
                                    <input type="password" name="current_password"
                                           class="form-control @error('current_password') is-invalid @enderror">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">New Password</label>
                                    <input type="password" name="new_password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-outline-primary rounded-pill w-100">
                                    Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right side - Order history -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Order History</h5>
                            @if($orders->count() > 0)
                                <div class="accordion" id="ordersAccordion">
                                    @foreach($orders as $order)
                                        <div class="accordion-item border mb-3 rounded shadow-sm">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed rounded" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#order-{{ $order->id }}">
                                                    <div class="d-flex justify-content-between w-100 me-3">
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
                                                                <td>{{ $item->product->name }}</td>
                                                                <td>{{ $item->quantity }}</td>
                                                                <td>{{ $item->price }} $</td>
                                                                <td>{{ $item->price * $item->quantity }} $</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    <p class="mb-1 small"><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->country }}</p>
                                                    <p class="mb-0 small"><strong>Phone:</strong> {{ $order->phone_number }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5>No orders yet!</h5>
                                    <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4 mt-3">
                                        Start Shopping
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
