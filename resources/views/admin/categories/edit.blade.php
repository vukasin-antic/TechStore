@extends('admin.layouts.admin-layout')

@section('Title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="admin-table">
                <div class="table-header">
                    <h5>Edit {{ $category->name }}</h5>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-2"></i>Back to Categories
                    </a>
                </div>
                <div class="p-4">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
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
                            <div class="col-12">
                                <label class="form-label fw-bold">Category Name</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ $category->name }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    Parent Category
                                    <span class="text-muted small fw-normal">(optional)</span>
                                </label>
                                <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                    <option value="">No parent (top level category)</option>
                                    @foreach($categories as $cat)
                                        @if($cat->id !== $category->id)
                                            <option value="{{ $cat->id }}"
                                                {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Selecting a parent makes this a subcategory.</small>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                    <i class="fas fa-save me-2"></i>Update Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
