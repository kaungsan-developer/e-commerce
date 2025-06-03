@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <p class="card-text">Total Products: {{ $products }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <p class="card-text">Total Orders: {{ $orders }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">Total Users: {{ $users }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Income</h5>
                        <p class="card-text">Total Income: {{ $totalIncome }} MMK</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
