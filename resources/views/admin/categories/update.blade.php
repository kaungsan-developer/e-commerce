@extends('layouts.app')
@section('content')
    <div class="container">
        <div>
            <div class="card mx-auto w-75">
                <h4 class="p-3">Update Category</h4>
                <form action="{{ route('category.update', $category->id) }}" method="POST" class="d-flex flex-column gap-3 px-3 py-1">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Category Name" value="{{ $category->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Category Description" value="{{ $category->description }}">
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
