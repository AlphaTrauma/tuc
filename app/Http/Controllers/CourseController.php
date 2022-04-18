<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('dashboard.courses.index');
    }

    public function create($id)
    {
        $direction = Direction::find($id);

        return view('dashboard.courses.create', compact('direction'));
    }
}
