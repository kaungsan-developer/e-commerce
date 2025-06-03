@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header px-2">
                        <h6 class="card-title">Edit Product</h6>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">
                                <!-- Product Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $product->name ?? 'Wireless Bluetooth Headphones') }}"
                                        placeholder="Enter product name" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Price -->
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control" id="price"
                                            name="price" value="{{ old('price', $product->price ?? 99.99) }}"
                                            placeholder="Enter price" required>
                                    </div>
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Stock -->
                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                        value="{{ old('stock', $product->stock ?? 100) }}"
                                        placeholder="Enter stock quantity" required>
                                    @error('stock')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required>
                                    {{ old('description', $product->description ?? 'High-quality wireless headphones with Bluetooth connectivity. Features noise cancellation, long battery life, and comfortable design.') }}
                                </textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Product Image -->
                                <div class="col-12 mb-3">
                                    <label for="image" class="form-label">Product Image</label>
                                    <div class="d-flex align-items-center">
                                        @if ($product->image)
                                            <img src="{{ asset('images/products/' . $product->image) }}"
                                                alt="{{ $product->name ?? 'Product Image' }}" class="img-thumbnail me-3"
                                                style="max-width: 100px;">
                                        @endif
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <!-- Status -->
                                <div class="col-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ $product->is_active ?? true ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                    @error('is_active')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    Update Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
