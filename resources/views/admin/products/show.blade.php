@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Product Image and Actions -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{asset('images/products/' . $product->image)}}" class="img-fluid mb-3" alt="Product Image">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{route('products.edit', $product)}}" class="btn btn-outline-primary me-2">Edit Product</a>
                        <form action="{{route('products.destroy', $product)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Delete Product</button>
                        </form>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-success me-2">Enable</button>
                        <button class="btn btn-outline-warning">Disable</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $product->name }}</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="h5">${{ $product->price }}</span>
                        <span class="badge bg-success">In Stock</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Category:</span>
                        <span>Electronics</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Brand:</span>
                        <span>Apple</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Stock:</span>
                        <span>{{ $product->stock }}</span>
                    </div>
                  
                 
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Product Description</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
            </div>
        </div>

        <!-- Sales Statistics -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Sales Statistics</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Sales:</span>
                        <span class="h5">125</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Revenue:</span>
                        <span class="h5">$24,997.50</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Last 30 Days:</span>
                        <span>25 Sales</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Average Rating:</span>
                        <span>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                            <span class="ms-2">4.5</span>
                        </span>
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
                                    <th>Customer</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD123456</td>
                                    <td>John Doe</td>
                                    <td>2</td>
                                    <td>$399.98</td>
                                    <td><span class="badge bg-success">Delivered</span></td>
                                    <td>May 25, 2025</td>
                                </tr>
                                <tr>
                                    <td>#ORD123457</td>
                                    <td>Jane Smith</td>
                                    <td>1</td>
                                    <td>$199.99</td>
                                    <td><span class="badge bg-warning">Processing</span></td>
                                    <td>May 24, 2025</td>
                                </tr>
                                <tr>
                                    <td>#ORD123458</td>
                                    <td>Mike Johnson</td>
                                    <td>3</td>
                                    <td>$599.97</td>
                                    <td><span class="badge bg-primary">Shipped</span></td>
                                    <td>May 23, 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
