@extends('layouts.layout')

@section('Title', 'Checkout')

@section('content')

    @include('fixed.page-header', [
        'title' => 'Checkout',
        'breadcrumbs' => [
            'Cart' => route('cart.index'),
            'Checkout' => '#'
        ]
    ])

    <!-- Checkout Page -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row g-5">

                    <!-- Left Side - Form -->
                    <div class="col-lg-7">
                        <h4 class="fw-bold mb-4">Delivery Information</h4>

                        @if($errors->any())
                            <div class="alert alert-warning mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                       value="{{ $user['first_name'] }}" required>
                                @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                       value="{{ $user['last_name'] }}" required>
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address') }}" placeholder="Street address" required>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                       value="{{ old('city') }}" placeholder="City" required>
                                @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                       value="{{ old('country') }}" placeholder="Country" required>
                                @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                       value="{{ old('phone_number') }}" placeholder="Phone number" required>
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes <span class="text-muted small">(optional)</span></label>
                                <textarea name="notes" class="form-control" rows="3"
                                          placeholder="Special delivery instructions..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Order Summary -->
                    <div class="col-lg-5">
                        <div class="bg-light rounded p-4" style="position: sticky; top: 100px;">
                            <h4 class="fw-bold mb-4">Order Summary</h4>

                            <div class="mb-3">
                                @foreach($cartItems as $item)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{$item->product->name}} x{{ $item->quantity }}</span>
                                        <span>{{$item->product->price * $item->quantity}} $</span>
                                    </div>
                                @endforeach
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>{{ $total }} $</span>
                            </div>

                            @if(session()->has('promo_applied'))
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Discount (20%):</span>
                                    <span>-{{ round($discount, 2) }} $</span>
                                </div>
                            @endif


                            <hr>

                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 fw-bold">Total:</h5>
                                <h5 class="mb-0 fw-bold">{{ round($total - $discount, 2) }} $</h5>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-pill w-100 py-3 text-uppercase fw-bold mb-2">
                                Place Order
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary rounded-pill w-100 py-3 text-uppercase fw-bold">
                                <i class="fas fa-arrow-left me-2"></i> Back to Cart
                            </a>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <script>
        var promoApplied = {{ session('promo_applied') ? 'true' : 'false' }};
    </script>

@endsection
