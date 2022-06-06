<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Document;
use App\Models\Image;
use App\Models\Material;
use App\Models\UserMaterial;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function create($id, $type)
    {
        return view('dashboard.materials.create', compact('id', 'type'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        if(!$data['material_type']) return back()->with('message', 'Ошибка типа материала');
        $block = Block::withCount('materials')->find($data['block_id']);
        $data['ordering'] = $block->materials_count + 1;
        $item = Material::create($data);

        if($request->hasFile('file')):
            switch($data['material_type']):
                case('pdf'):
                    Document::add($request->file('file'), 'materials/'.$block->id.'/'.$item->id, $item);
                break;
                case('image'):
                    Image::add($request->file('file'), 'materials/'.$block->id.'/'.$item->id, $item);
                break;
                #case('video'):
                #break;
                #case('link'):
                #break;
                #case('youtube'):
                #break;
            endswitch;

        endif;

        return back()->with('message', 'Успешно добавлен новый материал');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $material = Material::find($id);
        $material->update($data);

        return back()->with('message', 'Материал успешно отредактирован');
    }

    public function show($id)
    {
        $user_material = UserMaterial::with('material')->find($id);
        $material = $user_material->material;

        if($material and $user_material):
            $user_material->update(['status' => true]);
            return view('personal.courses.materials.'.$material->material_type, compact('user_material', 'material'));
        else:
            return back()->with('message', 'Ошибка при открытии материала');
        endif;

    }
}
