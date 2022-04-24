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
