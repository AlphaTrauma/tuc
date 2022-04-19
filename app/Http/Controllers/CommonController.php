<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\SliderItem;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function index(){
        $items = Direction::with('image')->where('status', 1)->get();
        $slides = SliderItem::with('image')->orderBy('ordering')->get();

        return view('index', compact('items', 'slides'));
    }
}
