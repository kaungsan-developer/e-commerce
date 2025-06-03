@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- User Profile Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h4>{{ $user->name }}</h4>
                            <p class="text-muted">Regular Customer</p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Email:</span>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Phone:</span>
                            <span>{{ $user->phone }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Address:</span>
                            <span>{{ $user->address }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Joined:</span>
                            <span>{{ $user->created_at->format('Y-m-d') }}</span>
                        </div>

                    </div>
                </div>
            </div>

            <!-- User Statistics Card -->
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">User Statistics</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-0">{{ $user->orders->sum('total_price') }}</h5>
                                        <p class="text-muted mb-0">Total Spent</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card ">
                                    <div class="card-body text-center">
                                        <h5 class="mb-0">{{ $user->orders->count() }}</h5>
                                        <p class="text-muted mb-0">Total Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card ">
                                    <div class="card-body text-center">
                                        <h5 class="mb-0">{{ $user->rates->avg('rating') }}</h5>
                                        <p class="text-muted mb-0">Average Rating</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Recent Orders</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $order->total_price }}</td>
                                            <td><span class="badge bg-success">{{ $order->status }}</span></td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('orders.show', $order->id) }}">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
