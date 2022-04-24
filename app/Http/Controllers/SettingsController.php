<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::query()->get()->keyBy('key');
        return view('dashboard.settings', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->except("_token");
        foreach($data as $key => $value):
            Settings::where('key', $key)->update(['value' => $value]);
        endforeach;

        return back()->with('message', 'Настройки успешно изменены');
    }
}
