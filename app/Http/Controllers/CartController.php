<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Menampilkan halaman cart.
     */
    public function index()
    {
        $cart = Session::get('cart', []);

        // Mendapatkan stok produk untuk batas maksimum kuantitas
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get(['id', 'stock']);
        $productStocks = $products->pluck('stock', 'id')->toArray();

        // Menghitung total harga
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'productStocks', 'total'));
    }

    /**
     * Menambahkan produk ke cart.
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = (int)$request->input('quantity', 1);

        // Memeriksa ketersediaan stok
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }

        // Mendapatkan cart dari session atau membuat array kosong
        $cart = Session::get('cart', []);

        // Menghitung jumlah total yang diinginkan
        $existingQuantity = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        $totalQuantity = $existingQuantity + $quantity;

        // Memeriksa apakah jumlah total melebihi stok
        if ($totalQuantity > $product->stock) {
            return redirect()->back()->with('error', 'Total quantity in cart exceeds available stock.');
        }

        // Menambahkan atau memperbarui produk di cart
        $cart[$id] = [
            'title'       => $product->title,
            'description' => $product->description,
            'category'    => $product->category,
            'price'       => $product->price,
            'quantity'    => $totalQuantity,
            'image'       => $product->image_path,
        ];

        // Menyimpan kembali cart ke session
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Memperbarui jumlah produk di cart.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = (int)$request->input('quantity', 1);

        // Memastikan jumlah minimal adalah 1
        if ($quantity < 1) {
            return redirect()->back()->with('error', 'Quantity must be at least 1.');
        }

        // Memeriksa ketersediaan stok
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }

        // Mendapatkan cart dari session
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully.');
        }

        return redirect()->back()->with('error', 'Product not found in cart.');
    }

    /**
     * Menghapus produk dari cart.
     */
    public function remove($id)
    {
        // Mendapatkan cart dari session
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed from cart.');
        }

        return redirect()->back()->with('error', 'Product not found in cart.');
    }
}
