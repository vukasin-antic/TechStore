@extends('admin.layouts.admin-layout')

@section('Title', 'Shop')
@section('page-title', 'Shop')

@section('content')

    <div class="container-fluid shop">
        <div class="container-fluid p-3">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="fw-bold mb-0">All Products</h5>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i>Add Product
                </a>

            </div>
            <form action="{{ route('admin.products.index') }}" method="GET" id="Admin-product">
                <div class="row my-3">
                    <div class="input-group d-flex">
                        <input type="search"
                               name="search"
                               class="form-control"
                               value="{{ request('search') }}"
                               placeholder="Search products..."/>
                        <button type="submit" class="input-group-text p-3">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="row g-3 justify-content-between my-3">
                    <div class="col-lg-3">
                        <select name="category" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-product').submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                @if($category->children->count() > 0)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}"
                                                {{ request('category') == $child->id ? 'selected' : '' }}>
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @else
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select name="brand" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-product').submit()">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select name="stock" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-product').submit()">
                            <option value="">All Stock</option>
                            <option value="in" {{ request('stock') == 'in' ? 'selected' : '' }}>In Stock</option>
                            <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Low Stock (≤5)</option>
                            <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select name="sort" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-product').submit()">
                            <option value="">Oldest First</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex align-items-center">
                        @if(request()->hasAny(['search', 'category', 'brand', 'stock', 'sort']))
                            <div class="mb-3">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="fas fa-times me-1"></i> Reset Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Product</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Brand</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="text-center">{{ $product->id }}</td>
                            <td class="text-center">
                                <div class="product-info">
                                    <img src="{{ $product->primaryImage->url }}" alt="" class="product-img">
                                    <span>{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ $product->description }}</td>
                            <td class="text-center">{{ $product->price }}</td>
                            <td class="text-center">{{ $product->stock }}</td>
                            <td class="text-center">{{ $product->category->name }}</td>
                            <td class="text-center">{{ $product->brand->name }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                       class="btn btn-sm btn-warning rounded-pill me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger rounded-pill btn-delete-product"
                                            data-id="{{ $product->id }}"
                                            data-product_name="{{ $product->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-12">
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
@section('additional-scripts')
    <script>
        $(document).on('click', '.btn-delete-product', function() {
            var productId = $(this).data('id');
            var product_name = $(this).data('product_name');
            var row = $(this).closest('tr');

            confirmDelete('Are you sure you want to delete product ' + product_name + '?', function() {
                $.ajax({
                    url: '/admin/products/' + productId,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                            showToast(response.message, true);
                        } else {
                            showToast(response.message, false);
                        }
                    }
                });
            });
        });
    </script>
@endsection
