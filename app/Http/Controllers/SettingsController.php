<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::with('document')->get()->keyBy('key');
        return view('dashboard.settings', compact('settings'));
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
}
