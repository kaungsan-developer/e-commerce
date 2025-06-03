<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ProductStoreRequest;
use App\Http\Requests\admin\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);
        if(!$request->query()){
            $products = Product::with('category')->get(); 
            $categories = Category::all();
            return view('admin.products.index', [
                'products' => $products,
                'categories' => $categories,
            ]);
        }
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
        
        
        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $this->authorize('create', Product::class);
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();
       
        $validated['image'] = uniqid() . $request->file('image')->getClientOriginalName();

        $request->file('image')->move(public_path('images/products'), $validated['image']);

        Product::create($validated);
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);
            return view('admin.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('view', $product);
        $categories = Category::all();
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /** 
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/products'), $validated['image']);
        }

        $product->update($validated);
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $productImage = public_path('images/products/' . $product->image);
        if(file_exists($productImage)){
            unlink($productImage);
        }
        $product->delete();
        return redirect()->route('products.index');
    }

                      
}
