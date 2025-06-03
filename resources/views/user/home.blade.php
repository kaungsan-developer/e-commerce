@extends('layouts.main')

@section('content')
    <div class=" mt-3">
        <!-- Hero Section -->
        <section class="container-fluid px-5 vh-100">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Welcome to Our Store</h1>
                    <p class="lead mb-4">your one-stop online shop for quality products at unbeatable prices. Discover the
                        latest in fashion, electronics, home essentials, beauty, and more. Enjoy fast shipping, secure
                        checkout, and 24/7 customer support. Start shopping smarter today!</p>
                    @guest
                        <a href="{{ route('register') }}" class="btn  btn-outline-primary">Sign Up</a>
                    @endguest
                    @auth
                        <a href="{{ route('viewAll') }}" class="btn  btn-outline-primary">Buy Now</a>
                    @endauth
                    <img src="{{ asset('images/web/cat.svg') }}" alt=""
                        style="width: 80px; height: 80px; margin-left: 10px; margin-top: 5px; opacity: 0.9;">

                </div>
                <div class="col-12 col-md-4 col-lg-6">
                    <img src="{{ asset('images/web/homeicon.svg') }}" alt="" class="bg-body"
                        style="width: 100%; opacity: 0.8;">

                </div>
            </div>

        </section>

        <!-- Featured Products -->
        <section id="products" class="py-5">
            <div class="container">
                <h2 class="text-center mb-5">Featured Products</h2>
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card product-card h-100">
                                <a href="{{ route('productDetail', $product->id) }}">

                                    <img src="{{ asset('images/products/' . $product->image) }}" alt="Product 1"
                                        style="width: 100%; height: 150px; object-fit: cover;">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"> {{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->category->name }}</p>
                                    <small>Stock: {{ $product->stock }}</small>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0 price">{{ $product->price }} MMK</span>

                                        <button type="button" class="btn btn-primary btn-sm addToCart"
                                            data-price="{{ $product->price }}" data-id={{ $product->id }}
                                            data-bs-toggle="modal" data-bs-target="#addToCartModal">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5">Shop by Category</h2>
                <div class="row g-4">
                    @foreach ($categories as $category)
                        @if ($category->products->count() > 0)
                            <div class="col-md-4">
                                <div class="card theme-color text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $category->name }}</h5>
                                        <p class="card-text">{{ $category->description }}</p>
                                        <a href="{{ url('product/search?category=' . $category->id) }}"
                                            class="btn btn-light">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h5>About Us</h5>
                        <p>Your trusted online shopping destination</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">About</a></li>
                            <li><a href="#" class="text-white">Contact</a></li>
                            <li><a href="#" class="text-white">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Contact</h5>
                        <p>Email: support@example.com<br>Phone: (555) 123-4567</p>
                    </div>
                </div>
            </div>
        </footer>


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
    @endsection
    @section('js')
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
    @endsection
