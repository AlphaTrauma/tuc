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
        $user->load('active_courses', 'active_courses.user_blocks', 'active_courses.user_blocks.block',
            'active_courses.user_blocks.user_materials', 'active_courses.course');

        return view('personal.courses.active', ['items' => $user->user_courses]);
    }

    public function completed()
    {
        $user = \Auth::user();
        $user->load('completed_courses', 'completed_courses.user_blocks', 'completed_courses.user_blocks.block',
            'completed_courses.user_blocks.user_materials', 'completed_courses.course');

        return view('personal.courses.completed', ['items' => $user->user_courses]);
    }
}
