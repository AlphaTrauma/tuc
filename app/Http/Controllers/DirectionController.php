<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateDirection;
use App\Models\Direction;
use Illuminate\Support\Str;
use App\Models\Image;
use App\Models\Type;

class DirectionController extends Controller
{
    public function index(){
        $items = Direction::with(['type', 'courses' => function($q){
            $q->withCount('blocks');
        }])->paginate(30);

        return view('dashboard.directions.index', compact('items'));
    }

    public function typed_index($id)
    {
        $type = Type::find($id);
        $items = Direction::with(['courses' => function($q){
            $q->withCount('blocks');
        }])->where('type_id', $id)->paginate(30);

        return view('dashboard.directions.index', compact('items', 'type'));
    }

    public function page()
    {
        $items = Type::has('directions')->with('image', 'directions')->where('status', 1)->get();

        return view('directions', compact('items'));
    }

    public function create($id)
    {
        $direction = Direction::create(['title' => 'Новое направление', 'type_id' => $id]);
        return redirect()->route('directions.edit', compact('direction'));
    }

    public function show($slug){
        $item = Direction::where('slug', $slug)->with(['courses' => function($q){
            $q->orderBy('title');
        }])->first();
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

        return redirect()->route('directions.by_type', $item->type_id)->with('message', 'Направление успешно отредактировано');
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
