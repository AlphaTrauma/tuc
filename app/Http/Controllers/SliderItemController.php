<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSlide;
use App\Models\Image;
use App\Models\SliderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SliderItemController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()):
            $slides = SliderItem::with('image')->orderBy('ordering')->get();
            return response($slides);
        endif;
        return view('dashboard.slider');
    }

    public function store(CreateSlide $request)
    {
        $item = SliderItem::create($request->except('_token'));
        if($request->hasFile('file')):
            Image::add($request->file('file'), 'slides/'.$item->id, $item);
        endif;

        return back()->with('message', 'Новый слайд успешно добавлен');
    }

    public function update(Request $request, $id){
        return response($request);
        $slide = SliderItem::with('image')->find($id);
        if(!$slide) return response(['error' => 'Обновляемый слайд не найден']);
        $slide->update($request->all());

        return response($slide);
    }

    public function updateImage($data){

        $slide = SliderItem::with('image')->find($data['id']);
        $filename = $data['file']->getClientOriginalName();
        if($slide->has('image')):
            $slide->image->delete();
        endif;
        $path = File::put('slides/'.$slide->id, $data['file'], $filename);
        $slide->image()->create(['filepath' => $path, 'filename' => $filename]);
        return response(['path' => $path]);
    }

    public function delete($id){
        $item = SliderItem::with('image')->find($id);
        if($item->has('image')):
            $item->image()->delete();
        endif;
        $item->delete();
        return response(['status' => 1]);
    }

}
