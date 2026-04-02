@extends('admin.layouts.admin-layout')

@section('Title', 'Users')
@section('page-title', 'Users')

@section('content')

    <div class="container-fluid shop">
        <div class="container-fluid p-3">
            <div class="d-flex mb-4">
                <h5 class="fw-bold mb-0">All Orders</h5>
            </div>
            <form action="{{ route('admin.users.index') }}" method="GET" id="Admin-user">
                <div class="row g-3 justify-content-between my-3">
                    <div class="col-xl-3">
                        <div class="input-group">
                            <input type="search"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Search by full name or email..."/>
                            <button type="submit" class="input-group-text p-3">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <select name="role" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-user').submit()">
                            <option value="">All Roles</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="col-xl-3">
                        <select name="orders" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-user').submit()">
                            <option value="">All Users</option>
                            <option value="has" {{ request('orders') == 'has' ? 'selected' : '' }}>Has Orders</option>
                            <option value="none" {{ request('orders') == 'none' ? 'selected' : '' }}>No Orders</option>
                        </select>
                    </div>
                    <div class="col-xl-3">
                        <select name="sort" class="form-select select-fixed"
                                onchange="document.getElementById('Admin-user').submit()">
                            <option value="">Oldest First</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex align-items-center">
                        @if(request()->hasAny(['search', 'role', 'orders', 'sort']))
                            <div class="mb-1">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="fas fa-times me-1"></i> Reset Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="inventory-table">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">First and last name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Role</th>
                <th class="text-center">Joined</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="text-center">{{ $user->id }}</td>
                    <td class="text-center">{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">
                        <span class="fs-6 badge rounded-pill px-3 {{ $user->role == 'admin' ? 'bg-success' : 'bg-primary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        @if($user->is_banned)
                            <span class="fs-6 badge bg-danger ms-1">Banned</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.show', $user->id) }}"
                           class="btn btn-sm btn-info rounded-pill me-1">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="btn btn-sm btn-warning rounded-pill me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($user->id != session('user')['id'])
                            <button class="btn btn-sm btn-danger rounded-pill btn-delete-user"
                                    data-id="{{ $user->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                        @if($user->id != session('user')['id'])
                            <button class="btn btn-sm {{ $user->is_banned ? 'btn-warning' : 'btn-danger' }} rounded-pill btn-ban-user"
                                    data-id="{{ $user->id }}"
                                    title="{{ $user->is_banned ? 'Unban user' : 'Ban user' }}">
                                <i class="fas {{ $user->is_banned ? 'fa-unlock' : 'fa-ban' }}"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No users found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="p-3">
            {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
        </div>


@endsection
@section('additional-scripts')
    <script>
        $(document).on('click', '.btn-delete-user', function() {
            var userId = $(this).data('id');
            var row = $(this).closest('tr');

            confirmDelete('Are you sure you want to delete this user?', function() {
                $.ajax({
                    url: '/admin/users/' + userId,
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

        $(document).on('click', '.btn-ban-user', function() {
            var userId = $(this).data('id');
            var btn = $(this);
            var isBanned = btn.hasClass('btn-warning');

            var message = isBanned
                ? 'Are you sure you want to unban this user?'
                : 'Are you sure you want to ban this user?';

            confirmDelete(message, function() {
                $.ajax({
                    url: '/admin/users/' + userId + '/ban',
                    method: 'POST',
                    data: { _token: $('meta[name="csrf-token"]').attr('content'), _method: 'PATCH' },
                    success: function(response) {
                        if (response.success) {
                            if (response.is_banned) {
                                btn.removeClass('btn-secondary').addClass('btn-warning');
                                btn.find('i').removeClass('fa-ban').addClass('fa-unlock');
                                btn.closest('tr').find('.badge.bg-danger').remove();
                                btn.closest('tr').find('td:nth-child(4)').append('<span class="badge bg-danger ms-1">Banned</span>');
                            } else {
                                btn.removeClass('btn-warning').addClass('btn-secondary');
                                btn.find('i').removeClass('fa-unlock').addClass('fa-ban');
                                btn.closest('tr').find('.badge.bg-danger').remove();
                            }
                            showToast(response.message);
                        } else {
                            showToast(response.message, false);
                        }
                    }
                });
            }, {
                title: isBanned ? 'Confirm Unban' : 'Confirm Ban',
                icon: isBanned ? 'fa-unlock text-info' : 'fa-ban text-danger',
                btnClass: isBanned ? 'btn-info' : 'btn-warning',
                btnText: isBanned ? 'Unban' : 'Ban'
            });
        });
    </script>
@endsection
