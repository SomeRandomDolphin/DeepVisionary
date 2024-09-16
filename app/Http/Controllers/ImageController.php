<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            $path = Storage::disk('supabase')->putFileAs('uploads', $image, $filename);
            $publicUrl = 'https://qpbjgvsfqfnqbrctahst.supabase.co/storage/v1/object/user_gallery/' . $path;

            return redirect()->back()->with('imageUrl', $publicUrl);
        }

        return redirect()->back()->with('error', 'No image uploaded.');
    }
}