<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    public function index(Request $request)
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::query();
        if($request->filled('status')){
            $orders->where('status', $request->status);
        }
        if($request->filled('sort')){
            switch($request->sort){
                case 'date_desc':
                    $orders->orderBy('created_at', 'desc');
                    break;
                case 'date_asc':
                    $orders->orderBy('created_at', 'asc');
                    break;
            }
            
        } else{
            $orders->orderBy('created_at', 'desc');
        }
        $orders = $orders->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('user', 'products');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        $order->update([
            'status' => $request->status
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return redirect()->route('admin.orders.index');
    }
}
