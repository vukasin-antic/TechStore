@extends('admin.layouts.admin-layout')

@section('Title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

    <div class="admin-table mb-4">
        <div class="p-4">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="admin-table">
                        <div class="table-header">
                            <h5>Edit {{ $user->first_name }} {{ $user->last_name }}</h5>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="fas fa-arrow-left me-2"></i>Back to Users
                            </a>
                        </div>
                        <div class="p-4">
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @if($errors->any())
                                    <div class="alert alert-warning mb-4">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <ul class="mb-0 list-unstyled">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">First Name</label>
                                        <input type="text" name="first_name"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               value="{{ $user->first_name }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Last Name</label>
                                        <input type="text" name="last_name"
                                               class="form-control @error('last_name') is-invalid @enderror"
                                               value="{{ $user->last_name }}">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ $user->email }}">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Role</label>
                                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                            <i class="fas fa-save me-2"></i>Update User
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
