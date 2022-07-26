<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Question;
use App\Models\Test;
use App\Models\Variant;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function edit(Request $request)
    {
        $block = Block::with('course')->find($request->route('id'));
        if($request->ajax()):
            $block->load('test.questions.variants');
            if($block->test):
                $test = $block->test;
            else:
                $test = $block->test()->create([
                    'title' => 'Новый тест',
                    'description' => 'Описание нового теста'
                ]);
            endif;
            return response(['test' => $test]);
        else:
            return view('dashboard.materials.test', ['course' => $block->course]);
        endif;

    }

    public function update(Request $request){
        $test = Test::find($request->route('id'));
        $test->update($request->except('_token'));

        return response($test);
    }

    public function addQuestion(Request $request)
    {
        $test = Test::withCount('questions')->find($request->route('id'));
        $question = $test->questions()->create(['text' => 'Новый вопрос', 'ordering' => $test->questions_count + 1]);

        return response($question);
    }

    public function updateQuestion(Request $request)
    {
        $question = Question::find($request->route('id'));
        $question->update(['text' => $request->input('text')]);

        return response($question);
    }

    public function deleteQuestion(Request $request)
    {
        $question = Question::withCount('variants')->find($request->route('id'));
        if(!$question->variants_count) $question->delete();

        return response(true);
    }

    public function addVariant(Request $request)
    {
        $question = Question::withCount('variants')->find($request->route('id'));
        $variant = $question->variants()->create(['text' => 'Новый вариант ответа', 'ordering' => $question->variants_count + 1]);

        return response($variant);
    }

    public function updateVariant(Request $request)
    {
        $variant = Variant::find($request->route('id'));
        $variant->update(['text' => $request->input('text')]);

        return response($variant);
    }

    public function deleteVariant(Request $request)
    {
        $variant = Variant::find($request->route('id'));
        $variant->delete();

        return response(true);
    }

    public function setCorrect(Request $request)
    {
        $question = Question::find($request->route('id'));
        $question->update(['correct' => $request->input('variant')]);

        return response(true);
    }

    public function delete($id){
        $test = Test::withCount('questions')->find($id);
        if($test->questions_count > 0):
            return back()->with('message', 'Нельзя удалять тестирование, содержащее вопросы');
        else:
            $test->delete();
            return back()->with('message', 'Тест удалён');
        endif;
    }
}
