<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLead;
use App\Models\Lead;
use App\Models\LeadsGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $type = isset($data['course']) && $data['course'] === 'height' ? ' на обучение "Высоте"' : ' с сайта';

        $client = new \GuzzleHttp\Client();

        $lead = 'Новая заявка'.$type.PHP_EOL.
            (isset($data['phone']) ? '<b>Телефон:</b> '.$data['phone'].PHP_EOL : '').
            (isset($data['email']) ? '<b>E-mail:</b> '.$data['email'].PHP_EOL : '').
            (isset($data['name']) ? '<b>Имя:</b> '.$data['name'].PHP_EOL : '').
            (isset($data['page']) ? '<b>Страница:</b> '.str_replace("xn--r1acj.xn--p1ai", "туц.рф", $data['page']).PHP_EOL : '').
            #(isset($data['course']) ? '<b>Курс:</b> '.$data['course'].PHP_EOL : '').
            (isset($data['comment']) ? '<b>Комментарий:</b> '.$data['comment'] : '');

        $ntfyLead = '## Новая заявка'.$type.PHP_EOL.
            (isset($data['phone']) ? '**Телефон:** '.$data['phone'].PHP_EOL : '').
            (isset($data['email']) ? '**E-mail:** '.$data['email'].PHP_EOL : '').
            (isset($data['name']) ? '**Имя:** '.$data['name'].PHP_EOL : '').
            (isset($data['page']) ? '**Страница:** '.str_replace("xn--r1acj.xn--p1ai", "туц.рф", $data['page']).PHP_EOL : '').
            #(isset($data['course']) ? '**Курс:** '.$data['course'].PHP_EOL : '').
            (isset($data['comment']) ? '**Комментарий:** '.$data['comment'] : '');

        $data = [
            'chat_id' => '-1001708032534',
            'parse_mode' => 'HTML',
            'text' => $lead
        ];

        # Отправка в telegram
        $client->postAsync(
            "https://api.telegram.org/bot5344836009:AAGH0z3JJdlfN10sNjK_457a_2C_mFrNc1k/sendMessage",
            ['form_params' => $data]
        );

        # Отправка в ntfy

        $this->sendNtfy($ntfyLead);

        return redirect()->route('lead.create')->with('message', 'Ваша заявка успешно отправлена');

    }

    private function sendNtfy($message)
    {
        $url = "https://ntfy.sh/tuc08b387c4171c";

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' =>
                    "Content-Type: text/markdown\r\nConnection: close\r\n",
                'content' => $message,
                'timeout' => 2,
                'ignore_errors' => true
            ],
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true
            ]
        ]);

        $result = @file_get_contents($url, false, $context);

        return $result;
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
        if($group->leads->count() < 1):
            $group->delete();
            return back()->with('message', 'Группа удалена');
        else:
            return back()->with('error', 'В группе уже есть заявки');
        endif;

    }

    public function destroy(Lead $lead)
    {
        //
    }
}
