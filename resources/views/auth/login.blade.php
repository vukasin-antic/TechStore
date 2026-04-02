@extends('layouts.layout')

@section('Title', 'Login')

@section('content')

    @include('fixed.page-header', [
        'title' => 'Login',
        'breadcrumbs' => [
            'Login' => '#'
        ]
    ])

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <form method="POST" action="{{ route('login') }}" class="border shadow p-4 rounded">
                    @csrf
                    <h2 class="text-center mb-4">Login</h2>
                    @if($errors->has('credentials'))
                        <div class="alert alert-warning m-0 py-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first('credentials') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="Enter email" value="admin@gmail.com" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"
                               class="form-control"
                               placeholder="Enter password" required value="admin123">
                    </div>

                    <button class="btn btn-primary w-100">Sign In</button>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="m-0">
                            Don't have an account? <a href="{{ route('register') }}">Create one right now!</a>
                        </p>


                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
