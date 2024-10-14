<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$products = Product::all();
        // dd($products);
        //return Inertia::render('Products/Index', ['products' => $products]);
        if(empty($request->input()['search_str'])) {
            $search_str = null;
            $products = Product::all();
        } else {
            $search_str = $request->input()['search_str'];
            $products = Product::where('name', 'LIKE', '%'.$search_str.'%')->get();
        }
        return Inertia::render('Products/Index', [
            'products' => $products,
            'search_str' => $search_str
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //dd($request);
        $products = new Product($request->input());
        $products->save();
        return redirect('products')->with('success_str', '登録完了しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //dd($product);
        return Inertia::render('Products/Edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->input());
        return redirect('products')->with('success_str', '更新完了しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('products');
    }
}
