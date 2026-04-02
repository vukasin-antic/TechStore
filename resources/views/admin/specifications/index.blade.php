@extends('admin.layouts.admin-layout')

@section('Title', 'Specifications')
@section('page-title', 'Specifications')

@section('content')

    <div class="container-fluid shop">
        <div class="container-fluid p-3">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="fw-bold mb-0">All Specifications</h5>
                <a href="{{ route('admin.specifications.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i>Add Specification
                </a>
            </div>
            <form action="{{ route('admin.specifications.index') }}" method="GET" id="Admin-spec">
                <div class="row g-4 justify-content-between my-3">
                    <div class="col-lg-6">
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
                    <div class="col-lg-6">
                        <select name="sort" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-spec').submit()">
                            <option value="">Oldest First</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="most" {{ request('sort') == 'most' ? 'selected' : '' }}>Most Used</option>
                            <option value="least" {{ request('sort') == 'least' ? 'selected' : '' }}>Least Used</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex align-items-center">
                        @if(request()->hasAny(['search', 'products', 'sort']))
                            <div class="mb-1">
                                <a href="{{ route('admin.specifications.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
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
                @forelse($specifications as $specification)
                    <tr>
                        <td class="text-center">{{ $specification->id }}</td>
                        <td class="text-center">{{ $specification->name }}</td>
                        <td class="text-center">{{ $specification->specifications_count }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.specifications.edit', $specification->id) }}"
                                   class="btn btn-sm btn-warning rounded-pill me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger rounded-pill btn-delete-specification"
                                        data-id="{{ $specification->id }}"
                                        data-specification="{{ $specification->name }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No Specifications found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-12">
            {{ $specifications->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
@section('additional-scripts')
    <script>
        $(document).on('click', '.btn-delete-specification', function() {
            var specificationId = $(this).data('id');
            var specification = $(this).data('specification');
            var row = $(this).closest('tr');

            confirmDelete('Are you sure you want to delete this specification: ' + specification + '?', function() {
                $.ajax({
                    url: '/admin/specifications/' + specificationId,
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
