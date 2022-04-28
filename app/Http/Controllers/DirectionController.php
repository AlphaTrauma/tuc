<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateDirection;
use App\Models\Direction;
use Illuminate\Support\Str;
use App\Models\Image;

class DirectionController extends Controller
{
    public function index(){
        $items = Direction::query()->paginate(30);

        return view('dashboard.directions.index', compact('items'));
    }

    public function page()
    {
        $items = Direction::query()->get();

        return view('directions', compact('items'));
    }

    public function create()
    {
        $direction = Direction::create(['title' => 'Новое направление']);
        return redirect()->route('directions.edit', compact('direction'));
    }

    public function show($slug){
        $item = Direction::where('slug', $slug)->first();
        if(!$item) return abort(404);

        return view('courses.direction', compact('item'));
    }

    public function update(UpdateDirection $request, $id) {
        $item = Direction::with('image')->find($id);
        $data = $request->except('_token');
        $data['slug'] =  Str::slug($data['title']);
        $item->update($data);

        if($request->hasFile('file')):
            Image::add($request->file('file'), 'directions/'.$item->id, $item);
        endif;

        return redirect()->route('directions.index')->with('message', 'Направление успешно отредактировано');
    }

    public function edit($id){
        $item = Direction::with('image')->find($id);
        return view('dashboard.directions.create', compact('item'));
    }

    public function destroy($id)
    {
        $item = Direction::with('image', 'courses')->find($id);
        if($item->courses->count() > 0) return back()->with('error', 'Нельзя удалить направление, содержащее курсы');

        $item->image()->delete();
        $item->delete();

        return back()->with('message', 'Направление успешно удалено');
    }
}
