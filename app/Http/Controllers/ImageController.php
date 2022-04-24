<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $items = Image::with('entity')->paginate(50);

        return view('dashboard.files.images', compact('items'));
    }

}
