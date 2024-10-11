<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show the product upload form
    public function create()
    {
        return view('upload');
    }

    // Handle the product upload
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $imageName = time().'.'.$request->image->extension();

        // Store image on your storage disk
        $path = $request->file('image')->storeAs('uploads/'.$user->id, $imageName, 'supabase');

        // Save product information to the database
        $product = new Product();
        $product->user_id     = $user->id;
        $product->title       = $request->title;
        $product->description = $request->description;
        $product->price       = $request->price;
        $product->stock       = $request->stock;
        $product->image_path  = $path;
        $product->save();

        return redirect()->route('dashboard')->with('productUploaded', true);
    }

    // Display the user's products on the dashboard
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();

        return view('dashboard', compact('products'));
    }

    // Show the product details
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $fileUrl = Storage::disk('supabase')->url($product->image_path);

        return view('catalog', compact('product', 'fileUrl'));
    }
}
