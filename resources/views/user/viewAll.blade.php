@extends('layouts.main')
@push('css')
    <style>
        .card {
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        img {
            border-radius: 10px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.5);
        }

        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4" id="main-container">
        <!-- Search and Filter Section -->

        <form class="" action="{{ route('search') }}" method="GET">
            <div class="row row-cols-1 row-cols-md-1 g-4 row-cols-lg-2 mb-4">
                <div class="col">
                    <div class="d-flex justify-content-end gap-3">
                        <div class="dropdown">
                            <select class="form-select form-select-sm" name="category">
                                <option value="All">All</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="dropdown">
                            <select class="form-select form-select-sm" name="price">
                                <option value="Price: Low to High">Low to High</option>
                                <option value="Price: High to Low">High to Low</option>
                            </select>
                        </div>

                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control form-control-sm" placeholder="Min Price"
                                name="min_price">
                            <input type="number" class="form-control form-control-sm" placeholder="Max Price"
                                name="max_price">
                        </div>
                    </div>
                </div>
                <!-- Search Bar -->
                <div class="col">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="search" name="query" placeholder="Search products...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </div>

                <!-- Filter Options -->

            </div>
        </form>
        @if ($products->isEmpty())
            <div class="alert alert-info text-center w-75 mx-auto mt-5" role="alert">
                Could not find any products
            </div>
        @endif
        <!-- Product Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="product-container">
            <!-- Product Card 1 -->
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card h-100">
                        <a href="{{ route('productDetail', $product) }}">
                            <img src="{{ asset('images/products/' . $product->image) }}" alt="Product 1"
                                style="width: 100%; height: 150px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"> {{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 price">{{ $product->price }} MMK</span>
                                <button type="button" class="btn btn-primary btn-sm addToCart"
                                    data-price="{{ $product->price }}" data-id={{ $product->id }} data-bs-toggle="modal"
                                    data-bs-target="#addToCartModal">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <div class="modal fade " id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Add to Cart</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" value="1" min="1"
                                        name="quantity">
                                    <span>Total: </span>
                                    <span id="addToCartPrice"></span>
                                    <input type="hidden" name="original_price" id="original_price" value="">
                                    <input type="hidden" name="price" id="addToCartPriceInput" value="5000">
                                    <input type="hidden" name="product_id" id="addToCartProductId" value="">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                                <button type="submit" class="btn btn-primary">Add To Cart</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            $('.addToCart').on('click', function() {
                $('#quantity').val(1);
                let price = $(this).data('price');
                $('#original_price').val(price);
                const productId = $(this).data('id');
                $('#addToCartProductId').val(productId);
                $('#addToCartPrice').text(parseFloat(price) + 'MMK');
                $('#addToCartPriceInput').val(price);
            });

            $('#quantity').on('change', function() {
                const originalPrice = parseFloat($('#original_price').val());
                let quantity = $(this).val();
                let totalPrice = quantity * originalPrice;
                $('#addToCartPrice').text(totalPrice + 'MMK');
                $('#addToCartPriceInput').val(totalPrice);
            });

        });
    </script>
@endpush
