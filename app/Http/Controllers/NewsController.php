<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $items = News::query()->latest()->paginate(30);

        return view('dashboard.news.index', compact('items'));
    }

    public function main()
    {
        $items = News::where('slug', '<>', null)->latest()->paginate(10);
        $title = 'Новости и акции';

        return view('news.index', compact('items', 'title'));
    }

    public function create()
    {
        $item = News::create(['title' => 'Новая новость']);

        return view('dashboard.news.create', compact('item'));
    }

    public function edit($id)
    {
        $item = News::find($id);

        return view('dashboard.news.create', compact('item'));
    }

    public function show($slug)
    {
        $item = News::with('images', 'courses')->where('slug', $slug)->first();

        if(!$item) return abort(404);

        return view('news.show', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = News::with('courses')->find($id);
        $data = $request->except("_token");
        if(!$data['slug']) $data['slug'] = Str::slug($data['title']);
        $item->update($data);
        foreach($item->courses as $course):
            if(!in_array($course->id, $data['courses'])) $item->courses()->detach($course->id);
        endforeach;
        foreach($data['courses'] as $id):
            if(!$item->courses->find($id)) $item->courses()->attach($id);
        endforeach;

        return redirect()->route('news.index')->with('message', 'Новость успешно сохранена');
    }

    public function delete(News $news)
    {
        $news->courses_links()->delete();
        $news->images()->delete();
        $news->delete();
        
        return redirect()->route('news.index')->with('message', 'Новость успешно удалена');
    }

    public function addImage(Request $request, $id)
    {
        if($request->hasFile('image')):
            $item = News::find($id);
            $image = Image::addTo($request->file('image'), 'news/'.$item->id, $item);
            return response(['filepath' => asset($image->filepath), 'id' => $image->id]);
        else:
            return 0;
        endif;
    }

}
