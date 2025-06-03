@extends('layouts.app')

@section('content')
    <div class="container ">
        <form action="{{ route('admin.index') }}" class="input-group mb-3 w-75 mx-auto" method="get">
            <input type="text" class="form-control" placeholder="Search" name="type">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </form>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ request('type') == 'all' ? 'active' : '' }}" aria-current="page"
                    href="{{ route('admin.index', ['type' => 'all']) }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('type') == 'admin' ? 'active' : '' }}"
                    href="{{ route('admin.index', ['type' => 'admin']) }}">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('type') == 'user' ? 'active' : '' }}"
                    href="{{ route('admin.index', ['type' => 'user']) }}">User</a>
            </li>
        </ul>
        @if ($users->isEmpty())
            <div class="alert alert-info text-center w-75 mx-auto mt-5" role="alert">
                Could not find any users
            </div>
        @endif
        @foreach ($users as $user)
            <div class="card mb-3">
                <div class="card-body d-flex flex-wrap justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">{{ $user->email }}</p>
                    </div>
                    <div class="">
                        <p>phone : {{ $user->phone }}</p>
                        <p>Address : {{ $user->address }}</p>
                    </div>
                    <div class="">
                        @if (!$user->is_admin)
                            <a href="{{ route('admin.show', $user->id) }}" class="btn btn-outline-primary">View</a>
                        @endif
                    </div>


                </div>
            </div>
        @endforeach
    </div>
@endsection
