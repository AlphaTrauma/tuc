<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDirection;
use App\Http\Requests\UpdateDirection;
use App\Models\Direction;
use Illuminate\Support\Str;
use App\Models\Image;

class DirectionController extends Controller
{
    public function index(){
        $items = Direction::query()->get();

        return view('dashboard.directions.index', compact('items'));
    }

    public function page()
    {
        $items = Direction::query()->get();

        return view('directions', compact('items'));
    }

    public function create()
    {
        return view('dashboard.directions.create');
    }

    public function show($slug){
        $item = Direction::where('slug', $slug)->first();
        if(!$item) return abort(404);

        return view('direction', compact('item'));
    }

    public function store(CreateDirection $request)
    {
        $data = $request->except('_token');
        $data['slug'] =  Str::slug($data['title']);
        $item = Direction::create($data);
        Image::add($request->file('file'), 'directions/'.$item->id, $item);

        return redirect()->route('directions.index')->with('message', 'Направление успешно сохранено');
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
}
