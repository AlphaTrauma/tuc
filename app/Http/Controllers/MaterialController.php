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
        if(isset($data['download'])) $data['download'] = 1;
        $item = Material::create($data);

        if($request->hasFile('file')):
            switch($data['material_type']):
                case('pdf'):
                    Document::add($request->file('file'), 'materials/'.$block->id.'/'.$item->id, $item);
                break;
                case('image'):
                    Image::add($request->file('file'), 'materials/'.$block->id.'/'.$item->id, $item);
                break;
            endswitch;
        endif;

        return back()->with('message', 'Успешно добавлен новый материал');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $material = Material::with('block')->find($id);
        if($material->material_type):
            $data['download'] = isset($data['download']) ? 1 : 0;
        endif;
        $material->update($data);

        if($request->hasFile('file')):
            switch($material->material_type):
                case('pdf'):
                    if($material->document) $material->document->delete();
                    Document::add($request->file('file'), 'materials/'.$material->block->id.'/'.$material->id, $material);
                    break;
                case('image'):
                    if($material->image) $material->image->delete();
                    Image::add($request->file('file'), 'materials/'.$material->block->id.'/'.$material->id, $material);
                    break;
            endswitch;
        endif;

        return back()->with('message', 'Материал успешно отредактирован');
    }

    public function destroy($id)
    {
        $item = Material::with('image', 'document')->find($id);
        if(isset($item->image->filepath)):
            $item->image->delete();
        endif;
        if(isset($item->document->filepath)):
            $item->document->delete();
        endif;
        $item->delete();

        return back()->with('message', 'Материал успешно удалён');
    }

    public function show($id)
    {
        $user_material = UserMaterial::with('material', 'user_block.block.course', 'user_block.block.test',
            'user_block.user_materials.material')->find($id);
        $material = $user_material->material;

        if($material and $user_material):
            $user_material->update(['status' => true]);
            return view('personal.courses.materials.'.$material->material_type, compact('user_material', 'material'));
        else:
            return back()->with('message', 'Ошибка при открытии материала');
        endif;

    }
}
