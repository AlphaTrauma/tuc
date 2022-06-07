<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourse;
use App\Http\Requests\UpdateCourse;
use App\Models\Direction;
use App\Models\Course;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $items = Course::with('direction')->latest()->paginate(30);

        return view('dashboard.courses.index', compact('items'));
    }

    public function show($id)
    {
        $item = Course::with('blocks')->find($id);

        return view('dashboard.courses.show', compact('item'));
    }

    public function create($id)
    {
        $direction = Direction::find($id);

        return view('dashboard.courses.create', compact('direction'));
    }

    public function store(CreateCourse $request)
    {
        $data = $request->except('_token');
        $item = Course::create($data);
        Image::add($request->file('file'), 'courses/'.$item->id, $item);

        return redirect()->route('directions.index')->with('message', 'Данные курса успешно сохранены');
    }

    public function edit($id){
        $item = Course::with('image', 'direction')->find($id);

        return view('dashboard.courses.create', compact('item'));
    }

    public function update(UpdateCourse $request, $id) {
        $item = Course::with('image')->find($id);
        $data = $request->except('_token');
        $item->update($data);

        if($request->hasFile('file')):
            Image::add($request->file('file'), 'courses/'.$item->id, $item);
        endif;

        return redirect()->route('directions.index')->with('message', 'Данные курса успешно отредактированы');
    }

    public function destroy($id)
    {

        $item = Course::with('image', 'blocks')->find($id);
        if($item->blocks->count() > 0) return back()->with('error', 'Нельзя удалить курс с внутренней структурой');
        $item->image()->delete();
        $item->delete();

        return back()->with('message', 'Курс успешно удалён');
    }

    public function getSelectData(Request $request, $id)
    {
        $options = Direction::with('courses:id,title,direction_id')->get(['id', 'title'])->toArray();
        $selected = \App\Models\News::with('courses:id,title,direction_id')->find($id)->courses->toArray();
        return response(['options' => $options, 'selected' => $selected]);
    }

    public function add(Request $request)
    {
        $data = $request->except('_token');
        $user = User::find($data['user_id']);
        $user->user_courses()->create(['course_id' => $data['course_id']]);

        return back()->with('message', 'Курс успешно добавлен студенту');
    }

}
