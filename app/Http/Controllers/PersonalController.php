<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\UserBlock;
use App\Models\UserCourse;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index(){
        return view('personal.index');
    }

    public function active()
    {
        $user = \Auth::user();
        $user->load('active_courses.course');

        return view('personal.courses.active', ['items' => $user->active_courses, 'title' => 'Активные курсы']);
    }

    public function closed()
    {
        $user = \Auth::user();
        $user->load('completed_courses.course');

        return view('personal.courses.active', ['items' => $user->completed_courses, 'title' => 'Завершённые курсы']);
    }

    public function show($id)
    {
        $user = \Auth::user();
        if(!$user->user_courses->contains('id', $id)) abort(404);
        $course = UserCourse::with('course', 'user_blocks.user_materials.material', 'user_blocks.block.test')->find($id);

        return view('personal.courses.show', ['user_course' => $course]);
    }

    public function test(Request $request)
    {
        $test = Test::with('questions.variants')->find($request->route('id'));

        return view('personal.courses.test', compact('test'));
    }

    public function checkTest(Request $request, $id, $block_id){
        $userBlock = UserBlock::with(['block.test.questions', 'user_course'])->find($request->route('block_id'));
        $questions = $userBlock->block->test->questions;
        $questions_count = $questions->count();
        $user_answers = $request->except('_token');
        $result = 0;

        foreach($user_answers as $question => $user_answer):
            $q_item = $questions->where('id', $question)->first();
            if($q_item->correct == $user_answer) $result += 1;
        endforeach;

        if($questions_count * ceil($userBlock->block->test->threshold/100) <= $result){
            if($userBlock->next()) $userBlock->next()->update(['status' => 0]);
            $userBlock->update(['done_at', now()]);
            $userBlock->user_test->update(['result' => $result, 'done_at' => now()]);
            if($this->checkCourse($userBlock->user_course)):
                $userBlock->user_course->update(['done_at' => now(), 'status' => 1]);
            endif;
            return redirect()->route('personal.course', ['id' => $userBlock->user_course->id])->with('message',
                "Тест успешно пройден, набрано $result из $questions_count баллов");
        } else {
            return redirect()->route('personal.course', ['id' => $userBlock->user_course->id])->with('message',
            "Тест не пройден, набрано $result из $questions_count баллов");
        }

    }

    private function checkCourse($course)
    {
        $course->load('user_blocks.user_test');
        $check = true;
        foreach($course->user_blocks as $user_block):
            if(!$user_block->user_test->done_at):
                $check = false;
            endif;
        endforeach;
        return $check;
    }

    public function completed()
    {
        $user = \Auth::user();
        $user->load('completed_courses.user_blocks.block', 'completed_courses.user_blocks.user_materials', 'completed_courses.course');

        return view('personal.courses.completed', ['items' => $user->user_courses]);
    }
}
