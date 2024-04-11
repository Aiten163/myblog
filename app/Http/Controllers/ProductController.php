<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('product.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }
    public function create()
    {
        $categories=Category::all();
        return view('product.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required'
        ]);
        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image
                    ->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
        $input['image'] = "$profileImage";
    }
        Product::create($input);
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }
    public function edit(Product $product)
    {
        $categories=Category::all();
        return view('product.edit', compact('product', 'categories'));
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required'
        ]);
        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image
            ->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
            } else {
            unset($input['image']);
        }
        $product->update($input);
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
