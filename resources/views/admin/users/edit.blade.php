@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card w-75 mx-auto">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-header">
                <h4>Edit Admin User</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control mt-2">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control mt-2">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control mt-2">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" class="form-control mt-2">
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label for="address">Address</label>
                    <input type="text" name="address" value="{{ $user->address }}" class="form-control mt-2">
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                </form>
            </div>
            <div class="mt-5 w-100 p-3">
                <h3>Account Delete</h3>
                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
