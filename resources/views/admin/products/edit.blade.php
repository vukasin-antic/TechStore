@extends('admin.layouts.admin-layout')

@section('Title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-table">
                <div class="table-header">
                    <h5>Edit {{ $product->name }}</h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>
                <div class="p-4">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                       value="{{ $product->name }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Price ($)</label>
                                <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                       value="{{ $product->price }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Stock</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                       value="{{ $product->stock }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        @if($category->children->count() > 0)
                                            <optgroup label="{{ $category->name }}">
                                                @foreach($category->children as $child)
                                                    <option value="{{ $child->id }}"
                                                        {{ $product->category_id == $child->id ? 'selected' : '' }}>
                                                        {{ $child->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Brand</label>
                                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Specifications</label>
                                @error('specs')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <div id="specsContainer">
                                    @foreach($product->specifications as $spec)
                                        <div class="d-flex gap-2 mb-2 align-items-center spec-row">
                                            <select name="specs[{{ $loop->index }}][type_id]" class="form-select">
                                                <option value="">Select Specification</option>
                                                @foreach($specTypes as $specType)
                                                    <option value="{{ $specType->id }}"
                                                        {{ $spec->specification_type_id == $specType->id ? 'selected' : '' }}>
                                                        {{ $specType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="specs[{{ $loop->index }}][value]"
                                                   class="form-control" value="{{ $spec->value }}" placeholder="Value">
                                            <button type="button" class="btn btn-danger btn-sm rounded-pill"
                                                    onclick="this.parentElement.remove()">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addSpec()">
                                    <i class="fas fa-plus me-2"></i>Add Specification
                                </button>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          rows="3">{{ $product->description }}</textarea>
                            </div>
                            <!-- Existing Images -->
                            <div class="col-12">
                                <label class="form-label fw-bold">Current Images</label>
                                <div class="row g-2 mb-3">
                                    @foreach($product->images as $image)
                                        <div class="col-md-2" id="image-{{ $image->id }}">
                                            <div class="position-relative">
                                                <img src="{{ $image->url }}"
                                                     class="img-fluid rounded border"
                                                     style="height:100px; object-fit:contain; width:100%">
                                                <div class="d-flex gap-1 mt-1">
                                                    <button type="button" class="btn btn-sm btn-danger w-100 btn-delete-image"
                                                            data-id="{{ $image->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    @if(!$image->is_primary)
                                                        <button type="button" class="btn btn-sm btn-outline-primary w-100 btn-set-primary"
                                                                data-id="{{ $image->id }}">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    @else
                                                        <span class="btn btn-sm btn-primary w-100 disabled">
                                                <i class="fas fa-star"></i> Primary
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <label class="form-label fw-bold">Add New Images</label>
                                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                                <small class="text-muted">Upload additional images for this product.</small>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                    <i class="fas fa-save me-2"></i>Update Product
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


        function addSpec() {
            var container = document.getElementById('specsContainer');
            var index = container.children.length;
            var div = document.createElement('div');
            div.className = 'd-flex gap-2 mb-2 align-items-center spec-row @error('specs') is-invalid @enderror'
            div.innerHTML = `
                    <select name="specs[${index}][type_id]" class="form-select @error('specs.*') is-invalid @enderror">
                        <option value="">Select Specification</option>
                        @foreach($specTypes as $specType)
            <option value="{{ $specType->id }}">{{ $specType->name }}</option>
                        @endforeach
            </select>
            <input type="text" name="specs[${index}][value]" class="form-control @error('specs.*.value') is-invalid @enderror" placeholder="Value">

                    <button type="button" class="btn btn-danger btn-sm rounded-pill" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>`;
            container.appendChild(div);
        }
        document.addEventListener(function() {
            var oldSpecs = @json(old('specs', []));
            var existingCount = {{ $product->specifications->count() }};

            // Only restore old specs if there are any
            // and skip the ones already rendered by Blade
            if (oldSpecs.length > existingCount) {
                oldSpecs.slice(existingCount).forEach(function(spec) {
                    addSpec(spec.type_id, spec.value);
                });
            }

        });

    </script>
@endsection
