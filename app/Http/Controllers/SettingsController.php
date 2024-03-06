<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Person;
use App\Models\Positions;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::with('document')->get()->keyBy('key');
        $personnel = Person::query()->orderBy('created_at')->get();
        $positions = Positions::query()->orderBy('created_at')->get();
        return view('dashboard.settings', compact('settings', 'personnel', 'positions'));
    }

    public function store(Request $request)
    {
        $data = $request->except("_token");
        foreach($data as $key => $value):
            Settings::where('key', $key)->update(['value' => $value]);
        endforeach;

        if($request->hasFile('file')):
            $price = Settings::where('key', 'pricelist')->first();
            if(!$price) $price = Settings::create(['key' => 'pricelist', 'value' => '', 'type' => 'contacts']);
            if($price->document) $price->document->delete();
            Document::add($request->file('file'), 'uploads/documents/', $price);
        endif;

        return back()->with('message', 'Настройки успешно изменены');
    }

    public function add_person(Request $request){
        $item = Person::create($request->except('_token'));
        if($item):
            return back()->with('message', 'Сотрудник успешно добавлен');
        else:
            return back()->with('error', 'Не удалось добавить сотрудника');
        endif;

    }

    public function remove_person(Person $person){
        $person->delete();
        return back()->with('message', 'Сотрудник удалён');
    }

    public function add_position(Request $request){
        $item = Positions::create($request->except('_token'));
        if($item):
            return back()->with('message', 'Должность успешно добавлена');
        else:
            return back()->with('error', 'Не удалось добавить должность');
        endif;

    }

    public function remove_position(Positions $positions){
        $positions->delete();
        return back()->with('message', 'Должность удалена');
    }
}
