<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class CatalogController extends Controller
{
    public function show($file)
    {
        $userId = Auth::user()->id;
        $fileUrl = Storage::disk('supabase')->url('uploads/' . $userId . '/' . $file);

        return view('catalog', ['fileUrl' => $fileUrl, 'fileName' => $file]);
    }
}
