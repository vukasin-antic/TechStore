@extends('layouts.layout')

@section('Title', 'Cart')
@section('keywords', 'cart, shopping cart, techstore')
@section('description', 'Your TechStore shopping cart.')
@section('content')

    @include('fixed.page-header', [
        'title' => 'Cart',
        'breadcrumbs' => [
            'Cart' => '#'
        ]
    ])

    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            @if($cartItems->count() > 0)
                <div class="row g-4">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cartItems as $item)
                                    <tr id="cart-item-{{ $item->id }}">
                                        <td>
                                            <img src="{{ $item->product->primaryImage->url }}"
                                                 alt="{{ $item->product->name }}"
                                                 style="width:80px; height:80px; object-fit:contain;">
                                        </td>
                                        <td>
                                            <a href="{{ route('product.show', $item->product->id) }}" class="text-dark fw-bold">
                                                <p class="mb-0 py-4">{{ $item->product->name }} $</p>
                                            </a>
                                        </td>
                                        <td>
                                            <p class="mb-0 py-4">{{ $item->product->price }} $</p>
                                        </td>
                                        <td>
                                            <div class="input-group quantity py-4" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                            data-id="{{ $item->id }}">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm text-center border-0 item-quantity bg-transparent"
                                                       value="{{ $item->quantity }}" data-id="{{ $item->id }}">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                            data-id="{{ $item->id }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0 py-4 item-total" id="item-total-{{ $item->id }}">
                                                {{ $item->product->price * $item->quantity }} $
                                            </p>
                                        </td>
                                        <td class="py-4">
                                            <button class="btn btn-md rounded-circle bg-light border btn-remove"
                                                    data-id="{{ $item->id }}">
                                                <i class="fa fa-times text-danger"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Cart Total (sticky) -->
                    <div class="col-lg-4">
                        <div class="bg-light rounded" style="position: sticky; top: 100px;">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>

                                <div class="d-flex justify-content-between mb-2">
                                    <h5 class="mb-0">Items:</h5>
                                    <p class="mb-0" id="cart-items-count">{{ $cartItems->sum('quantity') }}</p>
                                </div>

                                {{-- Show total before discount --}}
                                <div class="d-flex justify-content-between mb-2">
                                    <h5 class="mb-0">Total:</h5>
                                    <p class="mb-0" id="cart-subtotal">{{ round($total , 2) }} $</p>
                                </div>

                                {{-- Discount row - hidden by default, shows when promo is applied --}}
                                <div class="d-flex justify-content-between mb-2 text-success {{ session('promo_applied') ? '' : 'd-none' }}" id="discount-row">
                                    <h5 class="mb-0 text-success" id="discount-label">Discount: {{ $discountPercent }}%</h5>                                    <p class="mb-0 text-success" id="cart-discount">
                                        -{{ session('promo_applied') ? round($discount, 2) : '0.00' }} $
                                    </p>
                                </div>
                            </div>

                            {{-- Final total after discount --}}
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4">Final Total</h5>
                                <p class="mb-0 pe-4 fw-bold" id="cart-total">
                                    {{ round($finalTotal, 2) }} $
                                </p>
                            </div>

                            {{-- Promo code input --}}
                            <div class="px-4 mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="promoCode" placeholder="Promo code..." value="{{ session('promo_code') ?? '' }}">
                                    <button class="btn btn-outline-primary" id="applyPromo">Apply</button>
                                </div>
                                <small id="promoMessage" class="mt-1 d-block"></small>
                            </div>

                            <div class="px-4 pb-4">
                                <a href="{{ route('checkout.index') }}"
                                   class="btn btn-primary rounded-pill px-4 py-3 text-uppercase w-100">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h4>Your cart is empty</h4>
                    <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- Cart Page End -->

@endsection
@section('additional-scripts')
    <script>
        var itemInCart = document.getElementById('applyPromo');

        if(itemInCart)
        {
            itemInCart.addEventListener('click', function () {
                const code = document.getElementById('promoCode').value.trim().toUpperCase();
                const message = document.getElementById('promoMessage');

                if (!code) {
                    message.className = 'mt-1 d-block text-danger';
                    message.textContent = 'Please enter a promo code.';
                    return;
                }

                $.ajax({
                    url: '{{ route('cart.promo') }}',
                    method: 'POST',
                    data: { code: code },
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function(data) {
                        if (data.success) {
                            document.getElementById('discount-row').classList.remove('d-none');
                            document.getElementById('cart-discount').textContent = '-' + data.discount + ' $';
                            document.getElementById('cart-total').textContent = data.finalTotal + ' $';
                            document.getElementById('discount-label').innerHTML = 'Discount: ' + data.discountPercent + '%';
                            message.className = 'mt-1 d-block text-success';
                            message.textContent = data.message;
                        }
                        else {
                            document.getElementById('discount-row').classList.add('d-none');
                            document.getElementById('cart-discount').textContent = '-0.00 $';

                            document.getElementById('cart-total').textContent =
                                document.getElementById('cart-subtotal').textContent;

                            message.className = 'mt-1 d-block text-danger';
                            message.textContent = data.message;
                        }
                    },
                    error: function() {
                        message.className = 'mt-1 d-block text-danger';
                        message.textContent = 'Something went wrong. Please try again.';
                    }
                });
            })
        }

    </script>
@endsection
