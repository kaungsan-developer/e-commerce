<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\user\UserOrderStoreRequest;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserOrderStoreRequest $request)
    {
 
        $validated = $request->validated();
        $products = Product::whereIn('id', $validated['product_id'])->get();
        $total_amount = 0;
        foreach ($validated['product_id'] as $key => $product_id) {
           $total_amount += $products[$key]->price * $validated['quantity'][$key];
        }

        $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total_amount,
                'status' => 'pending',
                'address'=> 'testing',
                'phone' => '1234567890',
            ]);
        
        foreach ($validated['product_id'] as $key => $product_id) {
            
            $order->products()->attach($product_id, [
                'quantity' => $validated['quantity'][$key],
                'price' => $products[$key]->price,
                'total_price' => $products[$key]->price * $validated['quantity'][$key],
            ]);
            Auth::user()->cart->products()->detach($product_id);
            $products[$key]->stock -= $validated['quantity'][$key];
            $products[$key]->save();
        }
        return redirect()->to('/home')->with('success', 'Order created successfully');
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
    public function destroy(string $id)
    {
         return back();
    }
}
