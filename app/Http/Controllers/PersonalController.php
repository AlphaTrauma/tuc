<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index(){
        return view('personal.index');
    }

    public function active()
    {
        $user = \Auth::user();
        $user->load('user_courses', 'user_courses.user_blocks', 'user_courses.user_blocks.block', 'user_courses.user_blocks.user_materials', 'user_courses.course');
        $items = $user->user_courses->where('status', false);

        return view('personal.courses.active', compact('items'));
    }
}
