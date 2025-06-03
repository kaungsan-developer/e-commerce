<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\user\UserCartStoreRequest;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Auth::user()->cart);
        $cartItems = Auth::user()->cart()->with('products')->first();

        return view('user.cart', compact('cartItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.cart.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCartStoreRequest $request)
    {


        try {
            $validated = $request->validated();
            $product = Product::findOrFail($validated['product_id']);

            if ($product->stock < $validated['quantity']) {
                session()->flash('error', 'Insufficient product quantity available.');
                return redirect()->back();
            }
            if ($product->is_active !== 1) {
                session()->flash('error', 'Product is not available for purchase.');
                return redirect()->back();
            }
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);


            $existingProduct = $cart->products()->where('product_id', $validated['product_id'])->first();
            // checking if user is newly add to cart or adding same product to cart again

            if ($existingProduct) {

                // checking new quantity + existing quantity < stock 
                $totalQuantity = $existingProduct->pivot->quantity + $validated['quantity'];
                if ($totalQuantity > $product->stock) {
                    session()->flash('error', 'Insufficient product quantity available.');
                    return redirect()->back();
                }

                // product is already in cart so update the quantity and total price 
                $cart->products()->updateExistingPivot($validated['product_id'], [
                    'quantity' => $existingProduct->pivot->quantity + $validated['quantity'],
                    'total_price' => ($existingProduct->pivot->quantity + $validated['quantity']) * $product->price,
                ]);
                $product->decrement('stock', $totalQuantity);
            } else {
                // new add to cart so attach 
                $cart->products()->attach($product->id, [
                    'quantity' => $validated['quantity'],
                    'total_price' => $product->price * $validated['quantity'],
                ]);
               
            }
            return back()->with('success', 'Product added to cart successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
       $cart = Auth::user()->cart;
       $cart->products()->detach($id);
       return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully.');
    }
}
