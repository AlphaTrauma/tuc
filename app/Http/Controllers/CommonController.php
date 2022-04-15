<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function index(){
        $items = Direction::with('image')->where('status', 1)->get();

        return view('index', compact('items'));
    }
}
