<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLead;
use App\Models\Lead;
use App\Models\LeadsGroup;
use Illuminate\Http\Request;

class LeadController extends Controller
{

    public function index()
    {
        $items = Lead::query()->whereNull('course')->latest()->simplePaginate(50);

        return view('dashboard.leads.index', compact('items'));
    }

    public function indexByType($type){
        $groups = LeadsGroup::all();
        $items = Lead::with('user')->where('course', $type)->get()->groupBy('leads_groups_id');

        return view('dashboard.leads.leads_by_course', compact('items', 'type', 'groups'));
    }

    public function create(){
        return view('lead', ['title' => 'Оставить заявку']);
    }

    public function store(CreateLead $request)
    {
        $data = $request->all();
        Lead::create($data);
        $type = $data['course'] === 'height' ? ' на обучение "Высоте' : ' с сайта';
        $lead = 'Новая заявка'.$type.PHP_EOL.
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

    public function groups(){
        $leads_groups = LeadsGroup::query()->orderByDesc('created_at')->get();
        return view('dashboard.leads.leads_groups', compact('leads_groups'));
    }

    public function add_group(Request $request){
        $item = LeadsGroup::create($request->except('_token'));
        if($item):
            return back()->with('message', 'Группа успешно добавлена');
        else:
            return back()->with('error', 'Не удалось добавить группу');
        endif;

    }

    public function remove_group(LeadsGroup $group){
        $group->delete();
        return back()->with('message', 'Группа удалена');
    }

    public function destroy(Lead $lead)
    {
        //
    }
}
