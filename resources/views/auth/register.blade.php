@extends('layouts.layout')

@section('Title', 'Register')

@section('content')

    @include('fixed.page-header', [
        'title' => 'Register',
        'breadcrumbs' => [
            'Register' => '#'
        ]
    ])

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <form method="POST" action="{{ route('register.store') }}" class="border shadow p-4 rounded">
                    @csrf
                    <h2 class="text-center mb-4">Create Account</h2>

                    <div class="mb-3">
                        <label for="first_name" class="mb-2">First Name</label>
                        <input type="text" id="first_name" name="first_name"
                               class="form-control @error('first_name') is-invalid @enderror"
                               placeholder="Enter your first name"
                               value="{{ old('first_name') }}" required autofocus>
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="mb-2">Last Name</label>
                        <input type="text" id="last_name" name="last_name"
                               class="form-control @error('last_name') is-invalid @enderror"
                               placeholder="Enter your last name"
                               value="{{ old('last_name') }}" required>
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="mb-2">Email</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Enter email"
                               value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="mb-2">Password</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Create password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control"
                               placeholder="Confirm password" required>
                    </div>

                    <button class="btn btn-primary w-100 mt-1">Sign Up</button>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="m-0">
                            Already have an account? <a href="{{ route('login') }}">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
