<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Method to add product to cart
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = (int)$request->input('quantity', 1);

        // Get the cart from the session, or create an empty array if it doesn't exist
        $cart = Session::get('cart', []);

        // If product is already in cart, update the quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Add new product to cart

            dd($product->image_path); // Add this line

            $cart[$id] = [
                'title'     => $product->title,
                'price'     => $product->price,
                'quantity'  => $quantity,
                'image'     => $product->image_path,
            ];
        }

        // Save the cart back to the session
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // Method to display cart items
    public function index()
    {
        $cart = Session::get('cart', []);

        return view('cart.index', compact('cart'));
    }
}
