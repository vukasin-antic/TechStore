@extends('layouts.layout')

@section('Title', 'Contact')
@section('keywords', 'contact, support, techstore')
@section('description', 'Contact TechStore support team.')
@section('content')

    @include('fixed.page-header', [
        'title' => 'Contact',
        'breadcrumbs' => [
            'Contact' => '#'
        ]
    ])
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <h5 class="text-primary">Let's Connect</h5>
                <h1 class="display-5 mb-4">Send Your Message</h1>

                @if(session('success'))
                    <div class="alert alert-success mb-4">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

{{--                @if($errors->any())--}}
{{--                    <div class="alert alert-warning mb-4">--}}
{{--                        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}--}}
{{--                    </div>--}}
{{--                @endif--}}

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                       id="name" name="full_name" placeholder="Your Name"
                                       value="{{ old('full_name') }}">
                                <label for="name">Your Name</label>
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" placeholder="Your Email"
                                       value="{{ old('email') }}">
                                <label for="email">Your Email</label>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                       id="subject" name="subject" placeholder="Subject"
                                       value="{{ old('subject') }}">
                                <label for="subject">Subject</label>
                                @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      placeholder="Leave a message here" id="message"
                                      name="message" style="height: 160px">{{ old('message') }}</textarea>
                                <label for="message">Message</label>
                                @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
