<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLead;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{

    public function index()
    {
        $items = Lead::query()->latest()->get();

        return view('dashboard.leads', compact('items'));
    }

    public function create(){
        return view('lead', ['title' => 'Оставить заявку']);
    }

    public function store(CreateLead $request)
    {
        $data = $request->all();
        Lead::create($data);
        $lead = 'Новая заявка с сайта: '.
                '*Телефон:* '.$data['phone'].PHP_EOL.
                '*E-mail:* '.$data['email'].PHP_EOL.
                '*Имя:* '.$data['name'].PHP_EOL.
                '*Страница:* '.$data['page'].PHP_EOL.
                '*Курс:* '.$data['course'].PHP_EOL.
                '*Сообщение:* '.$data['comment'];
        $data = [
            'chat_id' => '-1001708032534',
            'text' => $lead
        ];
        $response = file_get_contents("https://api.telegram.org/bot5344836009:AAGH0z3JJdlfN10sNjK_457a_2C_mFrNc1k/sendMessage?".
            http_build_query($data) );

        return redirect()->route('lead.create')->with('message', 'Ваша заявка успешно отправлена');

    }

    public function read(Lead $lead)
    {
        $lead->update(['status' => true]);
        return back();
    }

    public function update(Request $request, Lead $lead)
    {
        //
    }

    public function destroy(Lead $lead)
    {
        //
    }
}
