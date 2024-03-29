<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Type;
use App\Models\SliderItem;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function index(){
        $items = Type::has('directions')->with('image', 'directions')->where('status', 1)->get();
        $slides = SliderItem::with('image')->orderBy('ordering')->get();

        return view('index', compact('items', 'slides'));
    }

    public function switchMode(){
        if(session()->has('impaired') and session('impaired') === true):
            session()->forget('impaired');
        else:
            session()->put('impaired', true);
        endif;
        return back();
    }
}
