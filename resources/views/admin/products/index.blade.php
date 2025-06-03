@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-3">
            <form class="" action="{{ route('products.index') }}" method="GET">
                <div class="row row-cols-1 row-cols-md-1 g-4 row-cols-lg-2 mb-4">
                    <div class="col">
                        <div class="d-flex justify-content-end gap-3">
                            <div class="dropdown">
                                <select class="form-select form-select-sm" name="category">
                                    <option value="All">All</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="dropdown">
                                <select class="form-select form-select-sm" name="price">
                                    <option value="Price: Low to High">Low to High</option>
                                    <option value="Price: High to Low">High to Low</option>
                                </select>
                            </div>

                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control form-control-sm" placeholder="Min Price"
                                    name="min_price">
                                <input type="number" class="form-control form-control-sm" placeholder="Max Price"
                                    name="max_price">
                            </div>
                        </div>
                    </div>
                    <!-- Search Bar -->
                    <div class="col">
                        <div class="input-group input-group-sm">
                            <input class="form-control" type="search" name="query" placeholder="Search products...">
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </div>

                    <!-- Filter Options -->

                </div>
            </form>
        </div>
        <div>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3 mx-auto">

                @foreach ($products as $product)
                    <div class="col">
                        <div class="card">
                            <a href="{{ route('products.show', $product) }}">
                                <div class="card-body p-0">
                                    <img src="{{ asset('images/products/' . $product->image) }}" alt=""
                                        style="width: 100%; height: 150px; object-fit: cover;">

                                </div>
                            </a>
                            <div class="card-footer">
                                <h5>Name : {{ $product->name }}</h5>
                                <p>Price : {{ $product->price }} MMK</p>
                                <p>Stock : {{ $product->stock }}</p>
                                <small>Category : {{ $product->category->name }}</small>
                                <div class="d-flex gap-2">
                                    <div>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-primary">Edit</a>
                                    </div>
                                    <div>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
