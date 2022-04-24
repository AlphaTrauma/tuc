<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Image;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();

        return view('dashboard.pages.index', compact('pages'));
    }

    public function show($slug)
    {
        $item = Page::with('images')->where('slug', $slug)->first();

        if(!$item) return abort(404);

        return view('page', compact('item'));
    }

    public function create()
    {
        $page = Page::create(['title' => 'Новая страница']);

        return redirect()->route('pages.edit', ['id' => $page->id]);
    }

    public function store(Request $request){
        $item = new Page;
        $item->fill($request->all());
        $item->text = '';
        $item->save();

        return Redirect()->route('pages');
    }

    public function edit($id)
    {
        $item = Page::find($id);

        return view('dashboard.pages.create', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Page::find($id);
        $item->update($request->all());

        return redirect()->route('pages')->with('message', 'Страница успешно изменена');
    }

    public function addImage(Request $request, $id)
    {
        if($request->hasFile('image')):
            $page = Page::find($id);
            $image = Image::addTo($request->file('image'), 'pages/'.$page->id, $page);
            return response(['filepath' => asset($image->filepath), 'id' => $image->id]);
        else:
            return 0;
        endif;
    }

    public function removeImage(Request $request, $id)
    {
        $path = $request->input('filepath');
        $filepath = str_replace(asset('/'), '', $path);
        $page = Page::with('images')->find($id);
        $page->images->where('filepath', $filepath)->each(function($item){
            $item->delete();
        });
    }

    public function destroy($id)
    {
        $item = Page::find($id);
        $item->images()->delete();
        $item->delete();

        return back()->with('message', 'Страница успешно удалена');
    }

}
