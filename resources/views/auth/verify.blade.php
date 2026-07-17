@extends('layouts.layout')

@section('Title', 'Verify Account')

@section('content')

    @include('fixed.page-header', [
        'title' => 'Verify Account',
        'breadcrumbs' => [
            'Verify Account' => '#'
        ]
    ])

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <form method="POST" action="{{ route('verify.store') }}" class="border shadow p-4 rounded">
                    @csrf
                    <h2 class="text-center mb-4">Verify Your Account</h2>

                    <p class="text-center text-muted">
                        We sent a 6-digit verification code to <strong>{{ $email }}</strong>.
                        Enter it below to activate your account.
                    </p>

                    @if(session('status'))
                        <div class="alert alert-success py-2">
                            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                        </div>
                    @endif

                    @if($errors->has('resend'))
                        <div class="alert alert-warning py-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first('resend') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="code" class="mb-2">Verification Code</label>
                        <input type="text" id="code" name="code" inputmode="numeric" maxlength="6"
                               class="form-control text-center fs-4 @error('code') is-invalid @enderror"
                               placeholder="Enter code" required autofocus autocomplete="one-time-code">
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary w-100 mt-1">Verify</button>
                </form>

                <form method="POST" action="{{ route('verify.resend') }}" class="text-center mt-3">
                    @csrf
                    <p class="m-0">
                        Didn't get the email?
                        <button type="submit" class="btn btn-link p-0 align-baseline">Resend code</button>
                    </p>
                </form>
            </div>
        </div>
    </div>

@endsection
