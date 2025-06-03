@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Filters and Actions -->
     <form class="mb-3 row row-cols-1 row-cols-md-2 row-cols-lg-3" method="get">
        <div class="col">
            <div class="d-flex justify-content-end">
                <select class="form-select me-2" name="status">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <select class="form-select" name="sort">
                    <option value="">Sort By</option>
                    <option value="date_desc">Newest First</option>
                    <option value="date_asc">Oldest First</option>
                </select>
            </div>
        </div>

         <div class="col">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>

     </form>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{-- <img src="https://via.placeholder.com/30" class="rounded-circle me-2" alt="Customer"> --}}
                                    <div>
                                        <h6 class="mb-0">{{ $order->user->name }}</h6>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{-- <img src="https://via.placeholder.com/40" class="me-2" alt="Product"> --}}
                                    <div>
                                        <span class="badge bg-primary me-1">{{ $order->products->count() }}</span>
                                        {{-- <span class="badge bg-primary">{{ $order->products->first()->name }}</span> --}}
                                    </div>
                                </div>
                            </td>
                            <td>{{ $order->total_amount }}</td>
                            <td>
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
                            </td>

                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="w-100 mt-4 text-center">
            {{ $orders->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        white-space: nowrap;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .table td img {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }
    
    .table td .btn-group {
        display: flex;
        gap: 5px;
    }
    
    .table td .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush