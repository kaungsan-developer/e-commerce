@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div>
            <div class="card mx-auto w-75">
                <h4 class="p-3">Create Category</h4>
                <form action="{{ route('category.store') }}" method="POST" class="d-flex flex-column gap-3 px-3 py-1">
                    @csrf
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Category Name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <input type="text" name="" class="form-control @error('description') is-invalid @enderror" placeholder="Category Description">
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <button type="submit" class="btn btn-primary w-100">Create</button>
                </form>
            </div>
            <h3 class="text-center mt-3 mb-3">Categories</h3>
            <p class="text-center text-danger">Deleting a category will delete all products in that category!</p>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3">
                @foreach ($categories as $category)
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                <p class="card-text">{{ $category->description }}</p>
                                <p class="card-text">Products: {{ $category->products->count() }}</p>
                                <div class="d-flex justify-content-between" >
                                    <form action="{{ route('category.edit', $category->id) }}" class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                </form>
                                <form action="{{route('products.index')}}" method="GET">
                                    <input type="hidden" name="category" value="{{ $category->id }}">
                                    @csrf
                                    @method('GET')
                                    <button type="submit" class="btn btn-info btn-sm">Products</button>
                                </form>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                   
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                   
                                </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection