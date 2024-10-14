<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Image;
use Illuminate\Support\Facades\Http;

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

        // Store image on Supabase
        $path = $request->file('image')->storeAs('uploads/'.$user->id, $imageName, 'supabase');

        // Get the URL of the uploaded image
        $baseUrl = 'https://qpbjgvsfqfnqbrctahst.supabase.co/storage/v1/object/public/user_gallery/';
        $fullPath = Storage::disk('supabase')->path($path);
        $imageUrl = $baseUrl . $fullPath;

        $category = 'Uncategorized';  // Default category

        try {
            // Resolve the path to the credentials file
            $credentialsPath = base_path(env('GOOGLE_APPLICATION_CREDENTIALS'));
            
            \Log::info('Attempting to use credentials file: ' . $credentialsPath);

            if (!file_exists($credentialsPath)) {
                throw new \Exception("Credentials file not found at: " . $credentialsPath);
            }

            // Initialize the Vision client with the service account key file
            $vision = new ImageAnnotatorClient([
                'credentials' => $credentialsPath
            ]);

            // Download the image content
            $response = Http::get($imageUrl);
            if ($response->failed()) {
                throw new \Exception("Failed to download image from Supabase");
            }
            $imageContent = $response->body();

            // Perform label detection
            $image = (new Image())->setContent($imageContent);
            $response = $vision->labelDetection($image);
            $labels = $response->getLabelAnnotations();

            if (!empty($labels)) {
                // Get the most likely category (first label)
                $category = $labels[0]->getDescription();
            }

            // Close the Vision client
            $vision->close();
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Google Vision API Error: ' . $e->getMessage());
            // You might want to flash a message to the user here
            session()->flash('error', 'Unable to categorize image. Using default category.');
        }

        // Save product information to the database
        $product = new Product();
        $product->user_id     = $user->id;
        $product->title       = $request->title;
        $product->description = $request->description;
        $product->price       = $request->price;
        $product->stock       = $request->stock;
        $product->image_path  = $path;
        $product->category    = $category;
        $product->save();

        return redirect()->route('dashboard')->with('productUploaded', true);
    }

    // Display the user's products on the dashboard
    public function seller(Request $request)
    {
        $user = Auth::user();
        $query = Product::where('user_id', $user->id);

        // Apply search filter
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Apply category filter
        if ($request->has('category') && $request->input('category') != 'all') {
            $query->where('category', $request->input('category'));
        }

        $products = $query->get();

        // Get unique categories for the filter dropdown
        $categories = Product::where('user_id', $user->id)->distinct('category')->pluck('category');

        return view('dashboard', compact('products', 'categories'));
    }

    // Display the user's products on the dashboard
    public function buyer(Request $request)
    {
        $query = Product::query();

        // Apply search filter
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Apply category filter
        if ($request->has('category') && $request->input('category') != 'all') {
            $query->where('category', $request->input('category'));
        }

        $products = $query->get();

        // Get unique categories for the filter dropdown
        $categories = Product::distinct('category')->pluck('category');

        return view('alldashboard', compact('products', 'categories'));
    }

    // Show the product details
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $fileUrl = Storage::disk('supabase')->url($product->image_path);

        return view('catalog', compact('product', 'fileUrl'));
    }
}
