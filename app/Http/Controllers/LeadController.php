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
        $lead = 'Новая заявка с сайта'.PHP_EOL.
            (isset($data['phone']) ? '<b>Телефон:</b> '.$data['phone'].PHP_EOL : '').
            (isset($data['email']) ? '<b>E-mail:</b> '.$data['email'].PHP_EOL : '').
            (isset($data['name']) ? '<b>Имя:</b> '.$data['name'].PHP_EOL : '').
            (isset($data['page']) ? '<b>Страница:</b> '.str_replace("xn--r1acj.xn--p1ai", "туц.рф", $data['page']).PHP_EOL : '').
            (isset($data['course']) ? '<b>Курс:</b> '.$data['course'].PHP_EOL : '').
            (isset($data['comment']) ? '<b>Комментарий:</b> '.$data['comment'] : '');
        $data = [
            'chat_id' => '-1001708032534',
            'parse_mode' => 'HTML',
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
