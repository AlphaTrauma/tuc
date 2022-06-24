<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Str;
use App\Models\Image;

class TypeController extends Controller
{

    public function index(){
        $items = Type::withCount('directions')->paginate(30);

        return view('dashboard.types.index', compact('items'));
    }

    public function create()
    {
        $type = Type::create(['title' => 'Новая форма обучения']);

        return redirect()->route('types.edit', compact('type'));
    }

    public function edit($id){
        $item = Type::with('image')->find($id);
        return view('dashboard.types.create', compact('item'));
    }

    public function update(Request $request, $id) {
        $item = Type::with('image')->find($id);
        $data = $request->except('_token');
        $data['slug'] =  Str::slug($data['title']);
        $item->update($data);

        if($request->hasFile('file')):
            Image::add($request->file('file'), 'types/'.$item->id, $item);
        endif;

        return redirect()->route('types.index')->with('message', 'Форма обучения успешно отредактирована');
    }

    public function destroy($id)
    {
        $item = Type::with('image', 'directions')->find($id);
        if($item->directions->count() > 0) return back()->with('error', 'Нельзя удалить форму обучения, содержащую материалы');

        $item->image()->delete();
        $item->delete();

        return back()->with('message', 'Форма обучения успешно удалена');
    }
}
