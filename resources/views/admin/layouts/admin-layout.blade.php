<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechStore Admin - @yield('Title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<div class="d-flex admin">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="logo">
            <i class="fas fa-shopping-bag me-2"></i>TechStore
        </div>
        <nav class="mt-3">
            <span class="nav-section">Main</span>
            <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <span class="nav-section">Shop</span>
            <a href="{{ route('admin.products.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Products
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Categories
            </a>
            <a href="{{ route('admin.brands.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <i class="fas fa-trademark"></i> Brands
            </a>
            <a href="{{ route('admin.specifications.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.specifications.*') ? 'active' : '' }}">
                <i class="fas fa-cogs"></i> Specifications
            </a>

            <span class="nav-section">Orders</span>
            <a href="{{ route('admin.orders.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Orders
            </a>

            <span class="nav-section">Users</span>
            <a href="{{ route('admin.users.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Users
            </a>

            <span class="nav-section">System</span>
            <a href="{{ route('admin.logs.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Activity Logs
            </a>

            <div class="mt-4 px-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Main -->
    <div class="admin-main w-100">
        <!-- Topbar -->
        <div class="admin-topbar">
            <h5 class="page-title">@yield('page-title')</h5>
            <a href="{{ route('home') }}">Home</a>
            <div class="user-info">
                <div class="avatar">{{ strtoupper(substr(session('user')['first_name'], 0, 1)) }}</div>
                <span>{{ session('user')['first_name'] }}</span>
            </div>
        </div>

        <!-- Content -->
        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="cartToast" class="toast align-items-center text-white bg-primary border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="cartToast" class="toast align-items-center text-white bg-primary border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                Product added to cart!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3" id="deleteModalIcon"></i>
                <p class="mb-0" id="deleteModalMessage">Are you sure you want to delete this item?</p>
                <small class="text-muted">This action cannot be undone.</small>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-danger rounded-pill px-4" id="confirmDeleteBtn">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var deleteCallback = null;
    var deleteModal = null;

    window.confirmDelete = function(message, callback, options) {
        options = options || {};
        document.getElementById('deleteModalLabel').textContent = options.title || 'Confirm Delete';
        document.getElementById('deleteModalMessage').textContent = message;
        document.getElementById('deleteModalIcon').className = 'fas fa-3x mb-3 ' + (options.icon || 'fa-exclamation-triangle text-warning');
        var btn = document.getElementById('confirmDeleteBtn');
        btn.className = 'btn rounded-pill px-4 ' + (options.btnClass || 'btn-danger');
        btn.textContent = options.btnText || 'Delete';
        deleteCallback = callback;
        deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteCallback) {
                deleteCallback();
                deleteCallback = null;
            }
            deleteModal.hide();
        });
    });

    // Date range validation - date_to cannot be before date_from
    document.addEventListener('DOMContentLoaded', function() {
        var dateFrom = document.querySelector('input[name="date_from"]');
        var dateTo   = document.querySelector('input[name="date_to"]');

        if (dateFrom && dateTo) {
            dateFrom.addEventListener('change', function() {
                dateTo.min = this.value;
                if (dateTo.value && dateTo.value < this.value) {
                    dateTo.value = this.value;
                }
            });
            dateTo.addEventListener('change', function() {
                dateFrom.max = this.value;
                if (dateFrom.value && dateFrom.value > this.value) {
                    dateFrom.value = this.value;
                }
            });
            // Set initial constraints if values already exist (e.g. after form submit)
            if (dateFrom.value) dateTo.min = dateFrom.value;
            if (dateTo.value)   dateFrom.max = dateTo.value;
        }
    });
</script>

@include('fixed.script')
@yield('additional-scripts')
</body>
</html>
