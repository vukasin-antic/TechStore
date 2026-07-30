@extends('layouts.layout')

@section('Title', 'Shop')
@section('keywords', 'shop, products, laptops, electronics, techstore')
@section('description', 'Browse and filter products in TechStore online shop.')
@section('content')

    @include('fixed.page-header', [
        'title' => 'Shop',
        'breadcrumbs' => [
            'Shop' => '#'
        ]
    ])

    <!-- Shop Page Start -->
    <div class="container-fluid shop py-5 bg-white">
        <div class="container py-5">
            <div class="row g-4">
                <form action="{{ route('shop') }}" method="GET" id="filterForm">
                    <div class="row g-4">
                        <!-- Sidebar -->
                        <div class="col-lg-3">
                            <div class="accordion" id="sidebarAccordion">
                                <!-- Categories -->
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <div class="accordion-item border-0">
                                    <h4 class="accordion-header">
                                        <button class="accordion-button px-0 bg-white fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#categoriesCollapse">
                                            Categories
                                        </button>
                                    </h4>
                                    <div id="categoriesCollapse" class="accordion-collapse collapse show">
                                        <div class="accordion-body px-0">
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <a href="{{ route('shop', request()->only('brand', 'sort', 'search', 'min_price', 'max_price')) }}"
                                                       class="text-dark {{ !request('category') ? 'fw-bold text-primary' : '' }}">
                                                        All Products
                                                    </a>
                                                </li>
                                                @if(request()->hasAny(['category', 'brand', 'spec', 'search', 'sort', 'min_price', 'max_price']))
                                                    <li class="mb-2">
                                                        <a href="{{ route('shop') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                            <i class="fas fa-times me-1"></i> Reset Filters
                                                        </a>
                                                    </li>
                                                @endif
                                                @foreach($categories as $category)
                                                    <li class="mb-2">
                                                        @if($category->children->count() > 0)
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <span class="fw-bold text-dark">{{ $category->name }}</span>
                                                                <a href="{{ route('shop', array_merge(request()->only('brand', 'sort', 'search', 'min_price', 'max_price'), ['category' => $category->id])) }}"
                                                                   class="btn btn-sm text-primary p-0 {{ request('category') == $category->id ? 'fw-bold' : '' }}">
                                                                    See All →
                                                                </a>
                                                            </div>
                                                            <ul class="list-unstyled ms-3 mt-1">
                                                                @foreach($category->children as $child)
                                                                    <li class="mb-1">
                                                                        <div class="d-flex align-items-center justify-content-between">
                                                                            <a href="{{ route('shop', array_merge(request()->only('brand', 'sort', 'search'), ['category' => $child->id])) }}"
                                                                               class="text-dark {{ request('category') == $child->id ? 'fw-bold text-primary' : '' }}">
                                                                                {{ $child->name }}
                                                                            </a>
                                                                            <span class="text-muted small">{{ $child->products_count }}</span>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <a href="{{ route('shop', array_merge(request()->only('brand', 'sort', 'search'), ['category' => $category->id])) }}"
                                                                   class="text-dark {{ request('category') == $category->id ? 'fw-bold text-primary' : '' }}">
                                                                    {{ $category->name }}
                                                                </a>
                                                                <span class="text-muted small">{{ $category->products_count }}</span>
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Brands -->
                                <div class="accordion-item border-0">
                                    <h4 class="accordion-header">
                                        <button class="accordion-button px-0 bg-white fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#brandsCollapse">
                                            Brands
                                        </button>
                                    </h4>
                                    <div id="brandsCollapse" class="accordion-collapse collapse show">
                                        <div class="accordion-body px-0">
                                            @foreach($brands as $brand)
                                                @if(!request('category') || $brand->products_count > 0)
                                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                                        <div class="d-flex align-items-center">
                                                            <input type="checkbox" class="me-2" name="brand[]" value="{{ $brand->id }}"
                                                                   {{ in_array($brand->id, (array) request('brand')) ? 'checked' : '' }}
                                                                   onchange="document.getElementById('filterForm').submit()">
                                                            <label class="text-dark mb-0">{{ $brand->name }}</label>
                                                        </div>
                                                        <span class="text-muted small">{{ $brand->products_count }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Range -->
                                <div class="accordion-item border-0">
                                    <h4 class="accordion-header">
                                        <button class="accordion-button px-0 bg-white fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#priceCollapse">
                                            Price Range
                                        </button>
                                    </h4>
                                    <div id="priceCollapse" class="accordion-collapse collapse show">
                                        <div class="accordion-body px-0">

                                            {{-- Dual range slider --}}
                                            <div class="price-slider-wrapper position-relative mb-3" style="height: 20px;">
                                                <div class="price-track position-absolute w-100 rounded"
                                                     style="height:4px; background:#dee2e6; top:8px;"></div>
                                                <div class="price-fill position-absolute rounded"
                                                     id="priceFill"></div>
                                                <input type="range" class="price-thumb position-absolute" id="thumb_min"
                                                       min="{{ $minPrice }}" max="{{ $maxPrice }}" step="0.01"
                                                       value="{{ request('min_price', $minPrice) }}"
                                                       oninput="syncSlider()">
                                                <input type="range" class="price-thumb position-absolute" id="thumb_max"
                                                       min="{{ $minPrice }}" max="{{ $maxPrice }}" step="0.01"
                                                       value="{{ request('max_price', $maxPrice) }}"
                                                       oninput="syncSlider()">
                                            </div>

                                            {{-- Min / Max input polja --}}
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">$</span>
                                                    <input type="text" class="form-control" id="input_min"
                                                           min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                                           value="{{ request('min_price', $minPrice) }}"
                                                           oninput="syncFromInput('min')">
                                                </div>
                                                <span class="text-muted">—</span>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">$</span>
                                                    <input type="text" class="form-control" id="input_max"
                                                           min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                                           value="{{ request('max_price', $maxPrice) }}"
                                                           oninput="syncFromInput('max')">
                                                </div>
                                            </div>

                                            {{-- Skriveni inputi koji se salju u formu --}}
                                            <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price', $minPrice) }}">
                                            <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price', $maxPrice) }}">

                                            <button type="button" class="btn btn-sm btn-primary rounded-pill w-100 mt-1"
                                                    onclick="document.getElementById('filterForm').submit()">
                                                Apply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Specifications -->
                                @if($specTypes->count() > 0)
                                    <div class="accordion-item border-0">
                                        <h4 class="accordion-header">
                                            <button class="accordion-button px-0 bg-white fw-bold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#specsCollapse">
                                                Specifications
                                            </button>
                                        </h4>
                                        <div id="specsCollapse" class="accordion-collapse collapse show">
                                            <div class="accordion-body px-0">
                                                @foreach($specTypes as $specType)
                                                    <div class="mb-3">
                                                        <h6 class="fw-bold">{{ $specType->name }}</h6>
                                                        @foreach($specType->specifications as $spec)
                                                            <div class="d-flex align-items-center mb-1">
                                                                <input type="checkbox" class="me-2"
                                                                       name="spec[{{ $specType->id }}][]"
                                                                       value="{{ $spec->value }}"
                                                                       {{ isset(request('spec')[$specType->id]) && in_array($spec->value, request('spec')[$specType->id]) ? 'checked' : '' }}
                                                                       onchange="document.getElementById('filterForm').submit()">
                                                                <label class="text-dark mb-0">{{ $spec->value }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Products -->
                        <div class="col-lg-9">
                            <!-- Search and Sort -->
                            <div class="row g-4 mb-4">
                                <div class="col-xl-8">
                                    <div class="input-group w-100 mx-auto d-flex">
                                        <input type="search" name="search" class="form-control p-3"
                                               placeholder="Search products..."
                                               value="{{ request('search') }}">
                                        <button type="submit" class="input-group-text p-3">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between">
                                        <label for="sort">Sort By:</label>
                                        <select id="sort" name="sort" class="border-0 form-select-sm bg-light me-3"
                                                onchange="document.getElementById('filterForm').submit()">
                                            <option value="">Oldest First</option>
                                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!-- Recent Product Grid -->
                            @if(isset($recentlyViewed) && $recentlyViewed->count() > 0)
                                <div class="container-fluid recently-viewed">
                                    <div class="mx-auto text-center pb-5" style="max-width: 700px;">
                                        <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                                            Recently Viewed Products
                                        </h4>
                                    </div>
                                    <div class="recently-viewed-carousel owl-carousel pt-4" data-count="{{ $recentlyViewed->count() }}">
                                        @foreach($recentlyViewed as $r)
                                            <a href="{{ route('product.show', $r->id) }}" class="text-decoration-none text-dark">
                                                <div class="border rounded">
                                                    <div class="product-item-inner-item py-3">
                                                        <img src="{{ $r->primaryImage->url }}"
                                                             class="img-fluid w-100 rounded-top" alt="{{ $r->name }}">
                                                    </div>
                                                    <div class="text-center rounded-bottom p-4">
                                                        <span class="d-block mb-2 text-primary">{{ $r->category->name }}</span>
                                                        <span class="h5 product-name">{{ $r->name }}</span>
                                                        <span class="text-primary fs-5">{{ $r->price }} $</span>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Product Grid -->
                            <div class="row g-4 product mt-1">
                                @forelse($products as $product)
                                    <div class="col-lg-4">
                                        <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-dark">
                                            <div class="product-item rounded">
                                                <div class="product-item-inner border rounded">
                                                    <div class="product-item-inner-item py-3">
                                                        <img src="{{ $product->primaryImage->url }}"
                                                             class="img-fluid w-100 rounded-top"
                                                             alt="{{ $product->name }}">
                                                    </div>
                                                    <div class="text-center rounded-bottom p-4">
                                                        <span class="d-block mb-2 text-primary">{{ $product->category->name }}</span>
                                                        <span class="d-block h5">{{ $product->name }}</span>
                                                        <span class="text-primary fs-5">{{ $product->price }} $</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-center">No products found.</p>
                                    </div>
                                @endforelse

                                <!-- Pagination -->
                                <div class="col-12 mt-5 d-flex justify-content-center">
                                    {{ $products->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Shop Page End -->

@endsection
@section('additional-scripts')
    <script>
        function syncSlider() {
            const minThumb = document.getElementById('thumb_min');
            const maxThumb = document.getElementById('thumb_max');
            let min = parseFloat(minThumb.value);
            let max = parseFloat(maxThumb.value);

            if (min > max) { min = max; minThumb.value = min; }
            if (max < min) { max = min; maxThumb.value = max; }

            document.getElementById('input_min').value = min;
            document.getElementById('input_max').value = max;

            document.getElementById('min_price').value = min;
            document.getElementById('max_price').value = max;

            const absMin = parseFloat(minThumb.min);
            const absMax = parseFloat(minThumb.max);
            const leftPct  = ((min - absMin) / (absMax - absMin)) * 100;
            const rightPct = ((max - absMin) / (absMax - absMin)) * 100;
            document.getElementById('priceFill').style.left  = leftPct  + '%';
            document.getElementById('priceFill').style.width = (rightPct - leftPct) + '%';
        }

        function syncFromInput(type) {
            const minThumb = document.getElementById('thumb_min');
            const maxThumb = document.getElementById('thumb_max');
            let min = parseFloat(document.getElementById('input_min').value) || parseFloat(minThumb.min);
            let max = parseFloat(document.getElementById('input_max').value) || parseFloat(maxThumb.max);

            if (type === 'min' && min > max) min = max;
            if (type === 'max' && max < min) max = min;

            minThumb.value = min;
            maxThumb.value = max;
            syncSlider();
        }

        document.addEventListener('DOMContentLoaded', syncSlider);
    </script>
@endsection
