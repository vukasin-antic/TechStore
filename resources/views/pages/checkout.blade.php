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

                        @if($addresses->count() > 0)
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Saved Addresses</label>
                                <select name="selected_address" id="selected_address" class="form-select mb-3"
                                        onchange="handleAddressSelect(this)">
                                    <option value="" disabled {{ !$addresses->where('is_default', true)->count() ? 'selected' : '' }}>
                                        -- Select an address --
                                    </option>
                                    @foreach($addresses as $address)
                                        <option value="{{ $address->id }}"
                                                data-address="{{ $address->address }}"
                                                data-city="{{ $address->city }}"
                                                data-country="{{ $address->country }}"
                                                data-phone="{{ $address->phone_number }}"
                                            {{ $address->is_default ? 'selected' : '' }}>
                                            {{ $address->label ? $address->label . ' — ' : '' }}
                                            {{ $address->address }}, {{ $address->city }}, {{ $address->country }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="selected_address_id" id="selected_address_id" value="">
                                <button class="btn btn-primary rounded-pill px-4" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#new-address-form"
                                        onclick="clearSelectedAddress()">
                                    <i class="fas fa-plus me-2"></i> Add Address
                                </button>
                            </div>
                        @endif

                        <div class="{{ $addresses->count() > 0 ? 'collapse' : '' }} mb-4" id="new-address-form">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" id="input_address"
                                           class="form-control @error('address') is-invalid @enderror"
                                           value="{{ old('address') }}" placeholder="Street address">
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" id="input_city"
                                           class="form-control @error('city') is-invalid @enderror"
                                           value="{{ old('city') }}" placeholder="City">
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" id="input_country"
                                           class="form-control @error('country') is-invalid @enderror"
                                           value="{{ old('country') }}" placeholder="Country">
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" id="input_phone"
                                           class="form-control @error('phone_number') is-invalid @enderror"
                                           value="{{ old('phone_number') }}" placeholder="Phone number">
                                    @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Notes <span class="text-muted small">(optional)</span></label>
                            <textarea name="notes" class="form-control" rows="3"
                                      placeholder="Special delivery instructions..."></textarea>
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
                                <span>{{ round($total, 2) }} $</span>
                            </div>

                            @if(session()->has('promo_applied'))
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Discount ({{ $discountPercent }}):</span>
                                    <span>-{{ round($discount, 2) }} $</span>
                                </div>
                            @endif

                            <hr>

                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 fw-bold">Total:</h5>
                                <h5 class="mb-0 fw-bold">{{ round($finalTotal, 2) }} $</h5>
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
@section('additional-scripts')
    <script>
        function handleAddressSelect(select) {
            const option = select.options[select.selectedIndex];
            document.getElementById('selected_address_id').value = option.value;
            document.getElementById('input_address').value = option.dataset.address;
            document.getElementById('input_city').value    = option.dataset.city;
            document.getElementById('input_country').value = option.dataset.country;
            document.getElementById('input_phone').value   = option.dataset.phone;

            const collapse = bootstrap.Collapse.getInstance(document.getElementById('new-address-form'));
            if (collapse) collapse.hide();
        }

        function clearSelectedAddress() {
            document.getElementById('selected_address_id').value = '';
            document.getElementById('selected_address').value = '';
            document.getElementById('input_address').value = '';
            document.getElementById('input_city').value    = '';
            document.getElementById('input_country').value = '';
            document.getElementById('input_phone').value   = '';
        }

        // Pri ucitavanju popuni inpute ako postoji default adresa
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('selected_address');
            if (select && select.value)
            {
                document.getElementById('selected_address_id').value = select.value;
                handleAddressSelect(select);
            }
        });

        var promoApplied = {{ session('promo_applied') ? 'true' : 'false' }};
    </script>
@endsection
