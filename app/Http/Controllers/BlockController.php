<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Course;
use Illuminate\Http\Request;

class BlockController extends Controller
{

    public function create($id)
    {
        $course = Course::find($id);

        return view('dashboard.blocks.create', compact('course'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $course = Course::withCount('blocks')->find($data['course_id']);
        $data['ordering'] = $course->blocks_count + 1;
        $item = Block::create($data);

        return redirect()->route('courses.show', $data['course_id'])->with('message', 'Успешно добавлен новый блок');
    }

    public function edit($id){
        $item = Block::find($id);
        return view('dashboard.blocks.create', compact('item'));
    }

    public function destroy($id)
    {
        $item = Block::find($id);
        #if($item->materials->count() > 0) return back()->with('error', 'Нельзя удалить блок, содержащий материалы');
        $item->delete();

        return back()->with('message', 'Блок успешно удалён');
    }
}
