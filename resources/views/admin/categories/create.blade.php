@extends('admin.layouts.admin-layout')

@section('Title', 'Add Category')
@section('page-title', 'Add Category')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-table">
                <div class="table-header">
                    <h5>Add New Category</h5>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-2"></i>Back to Categories
                    </a>
                </div>
                <div class="p-4">

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-warning mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0 list-unstyled">
                                    @foreach($errors->all() as $error)
                                        <li class="">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Category Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    Parent Category
                                    <span class="text-muted small fw-normal">(optional — leave empty for top level)</span>
                                </label>
                                <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                    <option value="">No parent (top level category)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">
                                    Selecting a parent makes this a subcategory.
                                    Example: "Mice" under "Peripherals"
                                </small>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                    <i class="fas fa-save me-2"></i>Add Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('additional-scripts')
    <script>
    </script>
@endsection
