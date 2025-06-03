@extends('layouts.main')
@section('content')
    <div class="container mt-3">


        <h1 class="text-center mb-4">Your<del style="font-size: 16px; opacity: 0.6">Cat</del>Cart</h1>

        <div class=""><button type="button" class="btn btn-sm btn-success w-100 mb-3" id="checkout"
                data-bs-toggle="modal" data-bs-target="#orderModal">Check Out</button></div>


        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                {{ session('success') }}
            </div>
        @endif

        @if (!$cartItems || is_null($cartItems->products))
            <div class="alert alert-info text-center">
                Your cart is empty. Start shopping now!
            </div>
        @else
            <div class="row gap-3">
                @foreach ($cartItems->products as $product)
                    <div class="card col-12 col-md-6 col-lg-3 mb-4 p-0">
                        <form action="{{ route('cart.destroy', $product->id) }}" method="POST" id="cartForm">
                            @csrf
                            @method('delete')

                            <div class="card-body p-0">
                                <img src="{{ asset('images/products/' . $product->image) }}" alt=""
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="card-footer">
                                <p>{{ $product->name }}</p>
                                <p class="price">Price:
                                    {{ $product->price }} MMK</p>
                                <small>Stock: {{ $product->stock }}</small>
                                <input type="number" name="quantity" value="{{ $product->pivot->quantity }}"
                                    data-id="{{ $product->id }}" min="1" id="cartQuantity">
                                <p data-price="{{ $product->price }}" data-id="{{ $product->id }}">Total:
                                    {{ $product->pivot->total_price }} MMK</p>
                                <button type="submit" class="btn btn-sm btn-danger w-100 mb-2">Remove</button>
                            </div>

                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Order</h3>
                    </div>
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            @if (!$cartItems || is_null($cartItems->products))
                                <div class="alert alert-info text-center">
                                    Your cart is empty. Start shopping now!
                                </div>
                            @else
                                @foreach ($cartItems->products as $product)
                                    <input type="checkbox" name="product_id[]" class="form-check-input"
                                        value="{{ $product->id }}" checked>
                                    <span>Product Name : {{ $product->name }}</span>
                                    <div class="d-flex align-items-center">
                                        <span>Quantity : </span>
                                        <input type="number" name="quantity[]" class="form-control w-25 " id="cartQuantity"
                                            data-id="{{ $product->id }}" value="{{ $product->pivot->quantity }}"
                                            min="1">
                                    </div>
                                    <p data-price="{{ $product->price }}" data-id="{{ $product->id }}">Total Price :
                                        {{ $product->pivot->total_price }}</p>
                                @endforeach
                            @endif

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-success">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('input#cartQuantity').on('input', function() {
                let id = $(this).data('id');
                let newVal = $(this).val();

                let same = $('input#cartQuantity[data-id="' + id + '"]').not(this);
                same.val(newVal);

                $('p[data-price][data-id="' + id + '"]').each(function() {
                    let price = $(this).data('price');
                    let total = price * newVal;
                    $(this).text(total + ' MMK');
                });
            });
        });
    </script>
@endsection
