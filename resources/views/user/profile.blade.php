@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <!-- Profile Header -->
        @if (session('success'))
            <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                <p>{{ session('success') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                </button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div>
                                <h2 class="card-title mb-1">{{ Auth::user()->name }}</h2>
                                <p class="card-text mb-1"><i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}</p>
                                <p class="card-text"><i class="fas fa-phone me-2"></i>{{ Auth::user()->phone ?? 'Not set' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Tabs -->
        <div class="row">
            <div class="col">
                <div class="nav nav-tabs" id="profileTabs" role="tablist">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                        type="button" role="tab">Profile Info</button>
                    <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button"
                        role="tab">My Orders</button>
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password"
                        type="button" role="tab">Password</button>
                </div>

                <div class="tab-content" id="profileTabsContent">
                    <!-- Profile Info Tab -->
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <div class="card mt-3">
                            <div class="card-body">
                                <form method="POST" action="{{ route('user.update', $user->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">



                                        <!-- Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ Auth::user()->name ?? '' }}" required>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ Auth::user()->email }}" required>
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="tel" class="form-control" id="phone" name="phone"
                                                value="{{ Auth::user()->phone ?? '' }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                value="{{ Auth::user()->address ?? '' }}">
                                        </div>



                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Tab -->
                    <div class="tab-pane fade" id="orders" role="tabpanel">
                        <div class="card mt-3">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Order History</h4>

                                @if ($user->orders->isEmpty())
                                    <div class="alert alert-info">
                                        No orders found.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user->orders as $order)
                                                    <tr>
                                                        <td>#{{ $order->id }}</td>
                                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                        <td>
                                                            <span
                                                                class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger') }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $order->total_amount }} MMK</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary" data-bs-toggle="collapse"
                                                                data-bs-target="#order{{ $order->id }}">
                                                                View Details
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="collapse" id="order{{ $order->id }}">
                                                                <div class="card card-body mt-2">
                                                                    <h6>Order Details:</h6>
                                                                    <div class="table-responsive">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Product</th>
                                                                                    <th>Quantity</th>
                                                                                    <th>Price</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($order->products as $product)
                                                                                    <tr>
                                                                                        <td>{{ $product->name }}</td>
                                                                                        <td>{{ $product->pivot->quantity }}
                                                                                        </td>
                                                                                        <td>{{ $product->pivot->total_price }}
                                                                                            MMK</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Address Tab -->
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card mt-3">
                            <div class="card-body">
                                <form method="POST" action="{{ route('password.change', $user->id) }}">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>

                                <div class="mt-5 border-top pt-3">
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger w-100">Account Delete</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
