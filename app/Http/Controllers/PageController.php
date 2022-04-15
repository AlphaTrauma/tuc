<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();

        return view('dashboard.pages.index', compact('pages'));
    }

    public function show($slug)
    {
        $item = Page::where('slug', $slug)->first();

        if(!$item) return abort(404);

        return view('page', compact('item'));
    }

    public function create()
    {
        return view('dashboard.pages.create');
    }

    public function store(Request $request){
        $item = new Page;
        $item->fill($request->all());
        $item->text = '';
        $item->save();

        return Redirect()->route('pages');
    }

    public function edit($slug)
    {
        $item = Page::where('slug', $slug)->first();

        return view('dashboard.pages.create', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Page::find($id);
        $item->update($request->all());

        return redirect()->route('pages')->with('message', 'Страница успешно изменена');
    }


}
