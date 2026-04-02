@extends('admin.layouts.admin-layout')

@section('Title', 'Create Brand')
@section('page-title', 'Create Brand')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="admin-table">
                <div class="table-header">
                    <h5>Add New Brand</h5>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-2"></i>Back to Brands
                    </a>
                </div>
                <div class="p-4">
                    <form action="{{ route('admin.brands.store')}}" method="POST">
                        @csrf

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
                            <div class="col-12">
                                <label class="form-label fw-bold">Brand Name</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                    <i class="fas fa-save me-2"></i>Add Brand
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
