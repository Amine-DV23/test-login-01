<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;



class ProductController extends Controller
{
    public function create()
    {
        $products = Product::all();
        return view('products.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'product_name' => 'required|string',
            'prix' => 'required|numeric',
            'fornisseur' => 'required|string',
            'prix_achat' => 'required|numeric',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        Product::create([
            'image' => $imagePath,
            'product_name' => $request->product_name,
            'prix' => $request->prix,
            'fornisseur' => $request->fornisseur,
            'prix_achat' => $request->prix_achat,
        ]);

        return back()->with('success', 'Product added successfully.');
    }

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string',
            'prix' => 'required|numeric',
            'fornisseur' => 'required|string',
            'prix_achat' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        $product->update($request->only('product_name', 'prix', 'fornisseur', 'prix_achat'));

        return back()->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('product_name', 'like', "$query%")->get();
        return response()->json($products);
    }
}
