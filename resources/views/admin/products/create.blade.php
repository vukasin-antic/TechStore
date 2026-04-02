@extends('admin.layouts.admin-layout')

@section('Title', 'Add Product')
@section('page-title', 'Add Product')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-table">
                <div class="table-header">
                    <h5>Add New Product</h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>
                <div class="p-4">

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label class="form-label fw-bold">Product Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Price ($)</label>
                                <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price') }}" >
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Stock</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                       value="{{ old('stock') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        @if($category->children->count() > 0)
                                            <optgroup label="{{ $category->name }}">
                                                @foreach($category->children as $child)
                                                    <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>
                                                        {{ $child->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Brand</label>
                                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Specifications</label>
                                <div id="specsContainer">
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addSpec()">
                                    <i class="fas fa-plus me-2"></i>Add Specification
                                </button>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Images</label>
                                <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" multiple accept="image/*">
                                <small class="text-muted">You can select multiple images. First image will be set as primary.</small>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                    <i class="fas fa-save me-2"></i>Add Product
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

        var specTypes = @json($specTypes->map(fn($s) => ['id' => $s->id, 'name' => $s->name]));

        function addSpec(typeId = '', value = '') {
            var container = document.getElementById('specsContainer');
            var index = container.children.length;

            var div = document.createElement('div');
            div.className = 'd-flex gap-2 mb-2 align-items-center spec-row'
            div.innerHTML = `
                    <select name="specs[${index}][type_id]" class="form-select">
                        <option value="">Select Specification</option>
                        @foreach($specTypes as $specType)
            <option value="{{ $specType->id }}">{{ $specType->name }}</option>
                        @endforeach
            </select>
            <input type="text" name="specs[${index}][value]" class="form-control" placeholder="Value">

                    <button type="button" class="btn btn-danger btn-sm rounded-pill" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>`;
            container.appendChild(div);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var oldSpecs = @json(old('specs', []));
            oldSpecs.forEach(function(spec) {
                addSpec();
                var rows = document.querySelectorAll('.spec-row');
                var lastRow = rows[rows.length - 1];
                lastRow.querySelector('select').value = spec.type_id;
                lastRow.querySelector('input').value = spec.value;
            });
        });
    </script>
@endsection
