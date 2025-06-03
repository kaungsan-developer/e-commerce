@extends('layouts.main')
@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <!-- Product Image Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('images/products/' . $product->image) }}" alt="Product Image"
                                class="img-fluid rounded shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title mb-3">{{ $product->name }}</h2>

                        <!-- Rating Section -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="rating">

                                @for ($i = 0; $i < $product->rates->avg('star'); $i++)
                                    <i class="fas fa-star text-warning"></i>
                                @endfor
                                @for ($i = 0; $i < 5 - $product->rates->avg('star'); $i++)
                                    <i class="fa-regular fa-star"></i>
                                @endfor
                            </div>
                            <span class="ms-2">({{ $product->rates->avg('star') }}) {{ $product->rates->count() }}
                                Reviews</span>
                        </div>

                        <!-- Price Section -->
                        <div class="price-section mb-3">
                            <h3 data-price="{{ $product->price }}" class="text-primary">{{ $product->price }} MMK</h3>


                        </div>

                        <!-- Quantity Selector -->
                        <form action="{{ route('cart.store') }}" method="POST" id='addToCartForm'>
                            @csrf
                            <div class="quantity-selector mb-3">
                                <p data-stock="{{ $product->stock }}">InStock : {{ $product->stock }}</p>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" name="quantity" type="button">-</button>
                                    <input type="number" class="form-control text-center" id="quantity" name="quantity"
                                        value="1" min="1">
                                    <button class="btn btn-outline-secondary" name="quantity" type="button">+</button>
                                </div>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </form>
                        <!-- Add to Cart Button -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg" id="addToCartFormSubmit">Add to Cart</button>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#buyModal">Buy
                                Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Order Form</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                            <input type="hidden" name="quantity[]" id="modalQuantity" value="1">
                            <p>Product Name : {{ $product->name }}</p>

                            <p>Quantity : <span id="modalQuantity">1</span></p>
                            <h3 name="modalPrice">{{ $product->price }} MMK</h3>
                        </div>
                        <div class="modal-footer">
                            <input type="text" name="address" placeholder="Address" class="form-control"
                                value="{{ Auth::user()->address ?? '' }}" required>
                            <input type="phone" name="phone" placeholder="Phone" class="form-control"
                                value="{{ Auth::user()->phone ?? '' }}" required>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Buy Now</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="card mt-4">
            <div class="card-body">
                <h3 class="card-title mb-3">Product Description</h3>
                <p class="card-text">
                    {{ $product->description }}
                </p>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="card mt-4">
            <div class="card-body">

                <form action="{{ route('rate.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <i data-star="1" class="fa-regular fa-star"></i>
                    <input type="checkbox" name="star" value="1" class="d-none">
                    <i data-star="2" class="fa-regular fa-star"></i>
                    <input type="checkbox" name="star" value="2" class="d-none">
                    <i data-star="3" class="fa-regular fa-star"></i>
                    <input type="checkbox" name="star" value="3" class="d-none">
                    <i data-star="4" class="fa-regular fa-star"></i>
                    <input type="checkbox" name="star" value="4" class="d-none">
                    <i data-star="5" class="fa-regular fa-star"></i>
                    <input type="checkbox" name="star" value="5" class="d-none">
                    <small>(Star Rating Required)</small>

                    <textarea name="feedback" class="form-control mt-2" id="" cols="30" rows="5"></textarea>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm mt-2 mb-2">Write a Review</button>
                    </div>
                </form>


                <h3 class="card-title mb-3">Customer Reviews</h3>
                <!-- Review Cards -->
                <div class="review-cards">
                    @foreach ($product->rates as $rate)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start w-100">
                                    <div class="w-100">
                                        <h5 class="card-title mb-1">{{ $rate->user->name }}</h5>
                                        <div class="rating mb-2">
                                            @for ($i = 0; $i < floor($rate->star); $i++)
                                                <i class="fas fa-star text-warning"></i>
                                            @endfor
                                            @for ($i = 0; $i < 5 - floor($rate->star); $i++)
                                                <i class="fa-regular fa-star"></i>
                                            @endfor

                                        </div>
                                        <p class="card-text">
                                            {{ $rate->feedback }}
                                        </p>
                                        <small class="text-muted">
                                            {{ $rate->created_at->format('Y-m-d') }}
                                        </small>
                                        <div class="d-flex justify-content-end">
                                            @auth
                                                @if ($rate->user_id === Auth::user()->id)
                                                    <form action="{{ route('rate.destroy', $rate) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm ms-auto">Delete</button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Quantity selector functionality
        $('.btn[name=quantity]').click(function() {
            var $input = $(this).siblings('input');
            var val = parseInt($input.val());

            if ($(this).html() === '+' && val < $('p').data('stock')) {
                $input.val(val + 1);
            } else if ($(this).html() === '-' && val > 1) {
                $input.val(val - 1);
            }
            var price = $('h3[data-price]').data('price');
            console.log(price);
            var quantity = $input.val();
            var total = price * quantity;
            $('input#modalQuantity').val(quantity);
            console.log(quantity);
            console.log($('input[name=quantity]').val());
            $('span#modalQuantity').text(quantity);

            $('h3[data-price]').text(total + ' MMK');
            $('h3[name=modalPrice]').text(total + ' MMK');


        });
        $('document').ready(function() {
            $('i.fa-star[data-star]').css('cursor', 'pointer');
            $('i.fa-star[data-star]').click(function() {
                $('input[type=checkbox]').prop('checked', false);
                $(this).addClass('fas text-warning');
                $(this).nextAll('i[data-star]').removeClass('fas text-warning');
                $(this).nextAll('i[data-star]').addClass('fa-regular');
                $(this).prevAll('i[data-star]').addClass('fas text-warning');
                $(this).next('input[type=checkbox]').prop('checked', true);
                console.log($(this).next('input[type=checkbox]').val());
            })
            $('#addToCartFormSubmit').click(function() {
                $('#addToCartForm').submit();
            })
        })
    </script>
@endsection
