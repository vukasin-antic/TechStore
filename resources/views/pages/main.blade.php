@extends('layouts.layout')
@section('Title', 'Home')
@section('keywords', 'techstore, electronics, laptops, phones, computers')
@section('description', 'TechStore - Your one-stop shop for the latest electronics and tech products.')
@section('content')

    <!-- Carousel Start -->
    <div class="container-fluid carousel bg-light px-0">
        <div class="row g-0 justify-content-center">
            <div class="col-12">
                <div class="header-carousel owl-carousel bg-light py-5">
                    <div class="row g-0 header-carousel-item align-items-center">
                        <div class="col-xl-6 carousel-img" >
                            <img src="{{ asset('img/carousel-1.png') }}" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="col-xl-6 carousel-content p-4">
                            <h4 class="text-uppercase fw-bold mb-4 "
                                style="letter-spacing: 3px;">Save Up To $400</h4>
                            <h1 class="display-3 text-capitalize mb-4 " >On Selected
                                Laptops & Desktop Or Smartphone</h1>
                            <p class="text-dark " >Terms and Condition Apply</p>
                            <a class="btn btn-primary rounded-pill py-3 px-5 "
                               href="{{ route('shop') }}">Shop Now</a>
                        </div>
                    </div>
                    <div class="row g-0 header-carousel-item align-items-center">
                        <div class="col-xl-6 carousel-img " >
                            <img src="{{ asset('img/carousel-2.png') }}" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="col-xl-6 carousel-content p-4">
                            <h4 class="text-uppercase fw-bold mb-4 "
                                style="letter-spacing: 3px;">Save Up To A $200</h4>
                            <h1 class="display-3 text-capitalize mb-4 " >On Selected
                                Laptops & Desktop Or Smartphone</h1>
                            <p class="text-dark " >Terms and Condition Apply</p>
                            <a class="btn btn-primary rounded-pill py-3 px-5 "
                               href="{{ route('shop') }}">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Carousel End -->

    <!-- Services Start -->
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-6 col-md-4 col-lg-2 border-start border-end " >
                <div class="p-4">
                    <div class="d-inline-flex align-items-center">
                        <i class="fa fa-sync-alt fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Free Return</h6>
                            <p class="mb-0">30 days money back guarantee!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end " >
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fab fa-telegram-plane fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Free Shipping</h6>
                            <p class="mb-0">Free shipping on all order</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end " >
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-life-ring fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Support 24/7</h6>
                            <p class="mb-0">We support online 24 hrs a day</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end " >
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-credit-card fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Receive Gift Card</h6>
                            <p class="mb-0">Recieve gift all over oder $50</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end " >
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-lock fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Secure Payment</h6>
                            <p class="mb-0">We Value Your Security</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end ">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-blog fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Online Service</h6>
                            <p class="mb-0">Free return products in 30 days</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    <!-- Our Products Start -->
    <div class="container-fluid bg-light product py-5">
        <div class="container py-5">
            <div class="tab-class">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Our Products</h1>
                    </div>
                </div>
                <div class="tab-content mt-4">
                    <div class="row g-4">
                        @foreach($products as $product)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-dark">
                                    <div class="product-item rounded">
                                        <div class="product-item-inner border rounded">
                                            <div class="product-item-inner-item py-3">
                                                <img src="{{ asset('img/products/' . $product->primaryImage->image) }}"
                                                     class="img-fluid w-100 rounded-top"
                                                     alt="{{ $product->name }}">                                            </div>
                                            <div class="text-center rounded-bottom p-4">
                                                <span class="d-block mb-2 text-primary">{{ $product->category->name }}</span>
                                                <span class="d-block h4">{{ $product->name }}</span>
                                                <span class="text-primary fs-5">{{ $product->price }} $</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Our Products End -->

    <!-- Product Banner Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-6 " >
                    <div class="text-center bg-primary rounded position-relative">
                        <img src=" {{ asset('img/product-banner-2.jpg') }}" class="img-fluid w-100" alt="">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4"
                             style="background: rgba(242, 139, 0, 0.5);">
                            <h2 class="display-2 text-secondary">SALE</h2>
                            <h4 class="display-5 text-white mb-4">Get UP To 50% Off</h4>
                            <a href="{{ route('shop') }}" class="btn btn-secondary rounded-pill align-self-center py-2 px-4">Shop
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Banner End -->
@endsection
