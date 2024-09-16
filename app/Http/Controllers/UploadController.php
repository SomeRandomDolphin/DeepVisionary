<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'image' => 'required|image|max:2048', // Validasi untuk memastikan file adalah gambar dan ukurannya tidak lebih dari 2MB
        ]);

        // Menyimpan file gambar
        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $request->image->storeAs('images', $filename, 'public');

            return back()->with('success', 'Image uploaded successfully')->with('imageName', $filename);
        }

        return back()->with('error', 'Failed to upload image');
    }
}

