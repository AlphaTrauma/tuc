<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Course;
use App\Models\Group;
use App\Models\Person;
use App\Models\Positions;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserGroups;
use App\Services\CreateDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;


class ContractorsController extends Controller
{
    public function index(){
        $items = Contractor::query()->get();
        return view('dashboard.contractors.index', compact('items'));
    }

    public function show(Contractor $item){
        $item->load('groups.users');

        $courses = Course::query()->whereNotNull('direction_id')->whereHas('blocks')->orderBy('title')->get();

        $users = $item->groups->pluck('users')->flatten();
        $user_courses = [];
        foreach($item->groups as $group):
            $ids = $group->users->pluck('id');
        $course_ids = DB::table('user_courses')
            ->whereIn('user_id', $ids)
            ->select('course_id')
            ->distinct()
            ->pluck('course_id');
        $user_courses[$group->id] = $courses->whereIn('id', $course_ids);
        endforeach;
        $courses = $courses->pluck('title', 'id')->toArray();
        $personnel = Person::all();
        $positions = Positions::all();
        return view('dashboard.contractors.show', compact('item', 'courses', 'personnel', 'positions', 'users', 'user_courses'));
    }

    public function copy($group_id){
        $group = Group::find($group_id);
        $copy = $group->replicate();
        $copy->created_at = Carbon::now();
        $copy->save();
        return back()->with('message', 'Настройки группы успешно скопированы');
    }

    public function deleteGroup($group_id){
        $group = Group::with('users')->find($group_id);
        if($group->users->count()):
            return back()->with('error', 'Группа содержит пользователей');
        else:
            $group->delete();
            return back()->with('message', 'Группа удалена');
        endif;

    }

    public function store(Request $request){
        $item = Contractor::create($request->all());
        return back()->with('message', $item ? 'Контрагент создан' : 'Не получилось создать контрагента');
    }

    public function destroy($id){
        $item = Contractor::find($id);
        if(!$item):
            return back()->with('error', 'Контрагент не найден');
        else:
            $item->delete();
            return back()->with('message', 'Контрагент успешно удалён');
        endif;

    }

    public function update(Request $request, Group $group){
        $group->update($request->all());
        return back()->with('message', 'Данные группы обновлены');
    }

    public function upload(Request $request, $id, $group_id = null){
        $contractor = Contractor::find($id);
        if(!$contractor) return back()->with('error', 'Ошибка: контрагент не обнаружен');
        if(!$request->hasFile('file')) return back()->with('error', 'Ошибка: не найден загруженный файл');
        $contractor->load('groups.users');
        $ex_users = $contractor->groups->pluck('users')->flatten();
        dd($ex_users);
        $file = $request->file('file');
        $filePath = $file->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rowCount = $sheet->getHighestRow();
        if($rowCount < 2) return back()->with('error', 'В загруженной таблице нет данных');
        if($group_id):
            $group = Group::find($group_id);

        else:
            $group = Group::create(['contractor_id' => $id]);
        endif;

        $users = []; $passwords = [];
        $sheet->setCellValue('J1', "Логин");
        $sheet->setCellValue('K1', "Пароль");
        $sheet->getColumnDimension("W")->setWidth(20);
        $sheet->getColumnDimension("X")->setWidth(20);
        for ($row = 2; $row <= $rowCount; $row++):
            if(!$sheet->getCell('A' . $row)->getValue()) continue;
            $user = new User();
            $user->last_name = $sheet->getCell('A' . $row)->getValue();
            $user->name = $sheet->getCell('B' . $row)->getValue();
            $user->patronymic = $sheet->getCell('C' . $row)->getValue();
            $user->position = $sheet->getCell('D'.$row)->getValue();
            $user->document = $sheet->getCell('G'.$row)->getValue();

            $user->birth_date = $sheet->getCell('E'.$row)->getValue();
            $user->snils = $sheet->getCell('F'.$row)->getValue();
            $user->phone = $sheet->getCell('H'.$row)->getValue();
            $user->doc_education = $sheet->getCell('I'.$row)->getValue();

            $ex_user = $ex_users->where('last_name', $user->last_name)->where('name', $user->name)->where('patronymic', $user->patronymic)->first();
            if($ex_user):
                UserGroups::firstOrCreate(['user_id' => $ex_user->id, 'group_id' => $group->id]);
                $user = $ex_user;
                $password = 'Пользователь уже существует';
            else:
                $user->email = Str::slug($user->last_name).Str::slug($user->name ? $user->name :  '_')[0].Str::slug($user->patronymic ? $user->patronymic : '_')[0];
                $count = User::where('email', 'like', $user->email."%")->count();
                if($count > 0) $user->email .= $count;
                $password = $user->email.\App\Models\User::count();
                $user->password = Hash::make($password);
                $user->save();
                UserGroups::create(['user_id' => $user->id, 'group_id' => $group->id]);
            endif;
            $users[] = $user;
            $passwords[$user->id] = $password;
            $sheet->setCellValue('J'.$row, $user->email);
            $sheet->setCellValue('K'.$row, $password);
        endfor;
        self::message($users, $passwords, $id);

        $newSpreadsheet = new Spreadsheet();
        $newSpreadsheet->addExternalSheet($sheet, 0);
        if ($newSpreadsheet->getSheetCount() > 1):
            $newSpreadsheet->removeSheetByIndex(1);
        endif;
        $writer = new Xlsx($newSpreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="file.xlsx"');
        $writer->save('php://output');
        exit;
    }

    public function addUser(Request $request){
        if($request->group_id and $request->user_id):
            UserGroups::create(['user_id' => $request->user_id, 'group_id' => $request->group_id]);
            return back()->with('message', 'Пользователь прикреплён к группе');
        else:
            return back()->with('error', 'Пользователь не найден');
        endif;
    }

    public function removeUser($group_id, $user_id){
        UserGroups::query()->where(['user_id' => $user_id, 'group_id' => $group_id])->delete();
        return back()->with('message', 'Пользователь откреплён от группы');

    }

    public function downloadDocument(Group $group, $type, $pdf = false){

        $group->load('contractor', 'course.direction');
        $doc = new CreateDocument($group, $type);
        if($pdf):
            $doc->toPDF();
        else:
            $doc->download();
        endif;

    }

    private function message($users, $passwords, $id){
        $contractor = Contractor::find($id);
        $message = 'Регистрация группы пользователей для контрагента '.$contractor->short_name.':'.PHP_EOL;
        foreach($users as $user):
            $message.=
                $user->name.' '.$user->last_name.PHP_EOL.
                'Логин: '.$user->email.PHP_EOL.
                'Пароль: '.$passwords[$user->id].PHP_EOL.PHP_EOL;
        endforeach;
        $data = [
            'chat_id' => '-1001708032534',
            'parse_mode' => 'HTML',
            'text' => $message
        ];
        $response = file_get_contents("https://api.telegram.org/bot5344836009:AAGH0z3JJdlfN10sNjK_457a_2C_mFrNc1k/sendMessage?".
            http_build_query($data) );
    }
}
