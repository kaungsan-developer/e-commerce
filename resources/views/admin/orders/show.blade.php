@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Order Summary -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Order ID: {{ $order->id }}</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Order Date:</span>
                        <span>{{ $order->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Status:</span>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge bg-warning">{{ $order->status }}</span>
                                @break
                            @case('delivered')
                                <span class="badge bg-success">{{ $order->status }}</span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">{{ $order->status }}</span>
                                @break
                            @default
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                        @endswitch
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total:</span>
                        <span class="h5">{{ $order->total_amount }} MMK</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Customer Information</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Name:</span>
                        <span>{{ $order->user->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Email:</span>
                        <span>{{ $order->user->email }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Phone:</span>
                        <span>{{ $order->user->phone }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Shipping Address:</span>
                        <span>
                            {{ $order->user->address }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Order Items</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($order->products as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/products/' . $product->image) }}" style="width: 50px; height: 50px; object-fit: cover;" class="me-3 rounded" alt="Product">
                                            <div>
                                                <h6 class="mb-0">{{ $product->name }}</h6>
                                                <small class="text-muted">Color: Black</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $product->price }} MMK</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td>{{ $product->pivot->total_price }} MMK</td>
                                </tr>
                                @php
                                    $total += $product->pivot->quantity;
                                @endphp
                                @endforeach                               
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $total }} items</td>
                                    
                                    <td>{{ $order->total_amount }} MMK</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Order Timeline</h5>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-badge bg-success"></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">Order Placed</h6>
                                    <span class="timeline-date">{{ $order->created_at->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        </div>
                        @if($order->status == 'delivered' || $order->status == 'cancelled')
                        <div class="timeline-item mt-3">
                            <div class="timeline-badge bg-warning"></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">{{ $order->status }}</h6>
                                    <span class="timeline-date">{{ $order->updated_at->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Actions -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Actions</h5>
                    <div class="d-grid gap-2">
                        <form action="{{ route('orders.update', $order->id) }}" method="POST" class="w-100">
                            @csrf         
                            @method('PUT')                   
                            <input type="hidden" name="status" value="delivered">
                            <button type="submit" class="btn btn-primary w-100">Mark as Delivered</button>
                        </form>
                        <form action="{{ route('orders.update', $order->id) }}" method="POST" class="w-100">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger w-100">Cancel Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
