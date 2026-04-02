@extends('admin.layouts.admin-layout')

@section('Title', 'Edit Order')
@section('page-title', 'Edit Order')

@section('content')

    <div class="container-fluid shop">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="admin-table">
                    <div class="table-header">
                        <h5>Edit Order {{ $order->order_number }}</h5>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                            <i class="fas fa-arrow-left me-2"></i>Back to Orders
                        </a>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if($errors->any())
                                <div class="alert alert-warning mb-4">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <ul class="mb-0 list-unstyled">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="bg-light rounded p-3 mb-2">
                                        <p class="mb-1"><strong>Customer:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
                                        <p class="mb-1"><strong>Total:</strong> {{ $order->total_price }} $</p>
                                        <p class="mb-0"><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                @if($order->status === 'cancelled')
                                    <div class="alert alert-danger mb-3">
                                        <i class="fas fa-ban me-2"></i> This order has been cancelled and cannot be modified.
                                    </div>
                                @endif
                                <div class="col-12">
                                    <label class="form-label fw-bold">Order Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror"
                                        {{ $order->status === 'cancelled' ? 'disabled' : '' }}>
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                        <i class="fas fa-save me-2"></i>Update Order
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
