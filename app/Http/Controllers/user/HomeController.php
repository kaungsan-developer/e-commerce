<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::limit(4)->get();
        $categories = Category::all();
        return view('user.home', compact('products', 'categories'));
    }

    public function search(Request $request)
    {
        $query = Product::query();
        if($request->filled('query'))
        {
            $query->where('name', 'like', '%' . $request->input('query') . '%');
        }

        if($request->filled('category') && $request->category != 'All'){
            $query->where('category_id' , $request->category);
        }
        if($request->filled('min_price')){
            $query->where('price', '>=', $request->min_price);
        }

        if($request->filled('max_price')){
            $query->where('price', '<=', $request->max_price);
        }
        if($request->filled('price')){
            switch($request->price){
                case 'Price: Low to High':
                    $query->orderBy('price');
                    break;
                case 'Price: High to Low':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }

        $products = $query->get();
        $categories = Category::all();
        return view('user.viewAll', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function productDetail($id)
    {
        $product = Product::with('rates', 'rates.user')->find($id);
       
        return view('user.productDetail', compact('product'));
    }

    public function viewAll()
    {
        $products = Product::paginate(12);
        $categories = Category::all();
        return view('user.viewAll', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function profile(User $user)
    {
        $user = User::with('orders', 'orders.products')->find($user->id);
        return view('user.profile', compact('user'));
    }
}
