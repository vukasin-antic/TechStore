@extends('layouts.layout')

@section('Title', 'Shop')
@section('keywords', $product->name . ' ' . $product->category->name . ' ' . $product->brand->name . ' techstore')
@section('description', Str::limit($product->description, 150))
@section('content')


    <!-- Single Product -->
    <div class="container-fluid shop py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row g-4 single-product">
                        <!-- Images -->
                        <div class="col-xl-6">
                            <div class="single-carousel owl-carousel">
                                @foreach($product->images as $image)
                                    <div class="single-item"
                                         data-dot="<img class='img-fluid' src='{{ $image->url }}' alt=''>">
                                        <div class="single-inner rounded">
                                            <img src="{{ $image->url }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="col-xl-6">
                            <h4 class="fw-bold mb-3">{{ $product->name }}</h4>
                            <p class="mb-1">Category: <span class="text-primary">{{ $product->category->name }}</span></p>
                            <p class="mb-3">Brand: <span class="text-primary">{{ $product->brand->name }}</span></p>
                            <h5 class="fw-bold mb-4 text-primary">{{ $product->price }} $</h5>
                            <div class="d-flex flex-column mb-3">
                                <small>Available:
                                    @if($product->stock > 0)
                                        <strong class="text-primary">{{ $product->stock }} items in stock</strong>
                                    @else
                                        <strong class="text-danger">Out of stock</strong>
                                    @endif
                                </small>
                            </div>
                            <p class="mb-4">{{ $product->description }}</p>
                            <div class="input-group quantity mb-4" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0" value="1" name="quantity">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <button class="btn btn-primary border border-secondary rounded-pill px-4 py-2 mb-4 btn-add-to-cart"
                                    data-id="{{ $product->id }}">
                                <i class="fa fa-shopping-bag me-2 text-white"></i> Add to cart
                            </button>
                        </div>

                        <!-- Specifications -->
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                            data-bs-toggle="tab" data-bs-target="#nav-description">Description</button>
                                    <button class="nav-link border-white border-bottom-0" type="button"
                                            data-bs-toggle="tab" data-bs-target="#nav-specs">Specifications</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-description">
                                    <p>{{ $product->description }}</p>
                                </div>
                                <div class="tab-pane" id="nav-specs">
                                    <table class="table table-bordered">
                                        <tbody>
                                        @foreach($product->specifications as $spec)
                                            <tr>
                                                <td class="fw-bold w-25">{{ $spec->specificationType->name }}</td>
                                                <td>{{ $spec->value }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="container-fluid related-product pb-5">
            <div class="container">
                <div class="mx-auto text-center pb-5" style="max-width: 700px;">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                        Related Products
                    </h4>
                </div>
                <div class="related-carousel owl-carousel pt-4 d-flex justify-content-center" data-count="{{ $relatedProducts->count() }}">
                    @foreach($relatedProducts as $related)
                        <div class="related-item rounded">
                            <div class="related-item-inner border rounded">
                                <div class="related-item-inner-item product-item-inner-item py-3">
                                    <img src="{{ $related->primaryImage->url }}"
                                         class="img-fluid w-100 rounded-top" alt="{{ $related->name }}">
                                </div>
                                <div class="text-center rounded-bottom p-4">
                                    <span class="d-block mb-2 text-primary">{{ $related->category->name }}</span>
                                    <span class="d-block h5">{{ $related->name }}</span>
                                    <span class="text-primary fs-5">{{ $related->price }} $</span>
                                </div>
                            </div>
                            <div class="related-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                                <a href="{{ route('product.show', $related->id) }}"
                                   class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4">
                                    <i class="fa fa-eye me-2"></i> View Product
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection


