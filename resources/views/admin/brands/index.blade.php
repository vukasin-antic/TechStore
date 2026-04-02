@extends('admin.layouts.admin-layout')

@section('Title', 'Brands')
@section('page-title', 'Brands')

@section('content')

    <div class="container-fluid shop">
        <div class="container-fluid p-3">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="fw-bold mb-0">All Brands</h5>
                <a href="{{ route('admin.brands.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i>Add Brand
                </a>
            </div>
            <form action="{{ route('admin.brands.index') }}" method="GET" id="Admin-brand">
                <div class="row g-3 justify-content-between my-3">
                    <div class="col-lg-4">
                        <div class="input-group">
                            <input type="search"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Search by name..."/>
                            <button type="submit" class="input-group-text p-3">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <select name="products" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-brand').submit()">
                            <option value="">All Brands</option>
                            <option value="has" {{ request('products') == 'has' ? 'selected' : '' }}>Has Products</option>
                            <option value="none" {{ request('products') == 'none' ? 'selected' : '' }}>No Products</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <select name="sort" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-brand').submit()">
                            <option value="">Oldest First</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="most" {{ request('sort') == 'most' ? 'selected' : '' }}>Most Products</option>
                            <option value="least" {{ request('sort') == 'least' ? 'selected' : '' }}>Least Products</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex align-items-center">
                        @if(request()->hasAny(['search', 'products', 'sort']))
                            <div class="mb-1">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
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
                    <th class="text-center">Name</th>
                    <th class="text-center">Products</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td class="text-center">{{ $brand->id }}</td>
                        <td class="text-center">{{ $brand->name }}</td>
                        <td class="text-center">{{ $brand->products_count }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                   class="btn btn-sm btn-warning rounded-pill me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger rounded-pill btn-delete btn-delete-brand"
                                        data-id="{{ $brand->id }}"
                                        data-brand="{{ $brand->name }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No brands found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-12">
            {{ $brands->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
@section('additional-scripts')
    <script>
        $(document).on('click', '.btn-delete-brand', function() {
            var brandId = $(this).data('id');
            var brand = $(this).data('brand');
            var row = $(this).closest('tr');

            confirmDelete('Are you sure you want to delete this brand: ' + brand + '?', function() {
                $.ajax({
                    url: '/admin/brands/' + brandId,
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
