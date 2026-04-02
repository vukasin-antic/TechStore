@extends('admin.layouts.admin-layout')

@section('Title', 'Categories')
@section('page-title', 'Categories')

@section('content')

    <div class="container-fluid shop">
        <div class="container-fluid p-3">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="fw-bold mb-0">All Categories</h5>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i>Add Category
                </a>
            </div>

            <form action="{{ route('admin.categories.index') }}" method="GET" id="Admin-category">
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
                        <select name="type" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-category').submit()">
                            <option value="">All Types</option>
                            <option value="parent" {{ request('type') == 'parent' ? 'selected' : '' }}>Parent Categories</option>
                            <option value="child" {{ request('type') == 'child' ? 'selected' : '' }}>Subcategories</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <select name="sort" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-category').submit()">
                            <option value="">Oldest First</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="most" {{ request('sort') == 'most' ? 'selected' : '' }}>Most Products</option>
                            <option value="least" {{ request('sort') == 'least' ? 'selected' : '' }}>Least Products</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex align-items-center">
                        @if(request()->hasAny(['search', 'type', 'sort']))
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
                    <th class="text-center">Parent Category</th>
                    <th class="text-center">Products</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="text-center">{{ $category->id }}</td>
                        <td class="text-center">{{ $category->name }}</td>
                        <td class="text-center">{{ $category->parent->name ?? '—' }}</td>
                        <td class="text-center">{{ $category->products_count }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="btn btn-sm btn-warning rounded-pill me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger rounded-pill btn-delete-category"
                                        data-id="{{ $category->id }}"
                                        data-category="{{ $category->name }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No categories found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        {{ $categories->withQueryString()->links('pagination::bootstrap-5') }}
    </div>

@endsection
@section('additional-scripts')
    <script>
        $(document).on('click', '.btn-delete-category', function() {
            var categoryId = $(this).data('id');
            var category = $(this).data('category');
            var row = $(this).closest('tr');

            confirmDelete('Are you sure you want to delete this category: ' + category + '?', function() {
                $.ajax({
                    url: '/admin/categories/' + categoryId,
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
