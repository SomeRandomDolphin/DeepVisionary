<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('register');
    }
});

Route::get('/welcome', function () {
    return view('welcome');
});

// Removed the conflicting /dashboard route
// Added middleware to the controller-based route
Route::get('/dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Removed the conflicting /upload route
// Added middleware to the controller-based routes
Route::get('/upload', [ProductController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('product.create');

Route::post('/upload', [ProductController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('product.upload');

// Modified the /catalog/{file} route to avoid conflict
Route::get('/catalog/file/{file}', [CatalogController::class, 'show'])
    ->middleware('auth')
    ->name('catalog.file.show');

// Ensure the /catalog/{id} route is correctly defined
Route::get('/catalog/{id}', [ProductController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('catalog.show');

// Existing route for image upload submission
Route::post('/upload/submit', [ImageController::class, 'submit'])->name('upload.submit');

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add')->middleware('auth');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

require __DIR__.'/auth.php';
