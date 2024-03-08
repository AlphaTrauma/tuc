<?php


namespace App\Services;

use App\Models\Settings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class CreateDocument
{
    private $group, $xlcx, $sheet, $index, $course, $direction, $director, $columns, $lastColumn, $title, $startDate, $endDate;

    public function __construct($group, $type)
    {
        $this->group = $group;
        $this->startDate = Carbon::parse($this->group->start_date ? $this->group->start_date : $this->group->created_at)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY');
        $this->endDate = $this->group->end_date ? Carbon::parse($this->group->end_date)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') : "__ ______ ____";
        if($group->users->first() and $group->users->first()->latestCourse and $group->users->first()->latestCourse->course):
            $this->course = $group->users->first()->latestCourse->course;
            $this->direction = $this->course->direction;
        else:
            $this->course = null;
            $this->direction = null;
        endif;
        $this->director = Settings::where('key', 'director')->first()->value;
        $this->init();
        $this->handle($type);
    }

    private function init(){
        $this->xlcx = new Spreadsheet();
        $this->sheet = $this->xlcx->getActiveSheet();
        $this->index = 1;
    }

    private function handle($type){
        $orientation = PageSetup::ORIENTATION_PORTRAIT;
        setlocale(LC_TIME, 'ru_RU.utf8');
        switch($type):
            case('orders'):
                $this->setColumns(['A' => 5, 'B' => 35, 'C' => 40, 'D' => 40]);
                $this->createOrders();
                $this->title = 'Приказы '.$this->group->created_at->format('d-m-Y').$this->group->contractor->short_name;
            break;
            case('statement'):
                $this->setColumns(['A' => 5, 'B' => 40, 'C' => 30, 'D' => 30, 'E' => 30]);
                $this->createStatement();
                $this->title = 'Ведомость выдачи пропусков '.$this->group->created_at->format('d-m-Y').$this->group->contractor->short_name;
            break;
            case('protocol'):
                $this->setColumns(['A' => 5, 'B' => 30, 'C' => 40, 'D' => 30, 'E' => 30]);
                $this->createProtocol();
                $this->title = 'Протокол '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
            break;
            case('certificates'):
                $this->setColumns(['A' => 15, 'B' => 35, 'C' => 25, 'D' => 25]);
                $this->createCertificates();
                $this->title = 'Удостоверения '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
            break;
            case('certificatesPC'):
                $this->setColumns(['A' => 20, 'B' => 20, 'C' => 20, 'D' => 60]);
                $this->createCertificatesPK();
                $this->title = 'Удостоверения ПК '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
                $orientation = PageSetup::ORIENTATION_LANDSCAPE;
                break;
            case('certificatesPrint'):
                $this->setColumns(['A' => 15, 'B' => 35, 'C' => 15, 'D' => 10, 'E' => 30, 'F' => 30]);
                $this->sheet->getStyle($this->columns[0]."1:".$this->lastColumn."1000")->getFont()->setName("Cambria");
                $this->sheet->getStyle($this->columns[0]."1:".$this->lastColumn."1000")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $this->createCertificatesPrint();
                $this->title = 'Удостоверения о повышении квалификации '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
                $orientation = PageSetup::ORIENTATION_LANDSCAPE;
                break;
            case('certificatesWorker'):
                $this->setColumns(['A' => 32, 'B' => 20, 'C' => 32, 'D' => 10, 'E' => 50, 'F' => 20]);
                $this->sheet->getStyle($this->columns[0]."1:".$this->lastColumn."1000")->getFont()->setName("Cambria");
                $this->sheet->getStyle($this->columns[0]."1:".$this->lastColumn."1000")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $this->certificatesWorker();
                $this->title = 'Свидетельство о профессии рабочего '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
                $orientation = PageSetup::ORIENTATION_LANDSCAPE;
                break;
            case('agreements'):
                $this->setColumns(['A' => 100]);
                $this->sheet->getStyle($this->columns[0]."1:".$this->lastColumn."1000")->getFont()->setName("Times New Roman")->setSize(12);
                $this->agreements();
                $this->title = 'Соглашения о п.д. '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
                break;
            case('certificatesWorker2'):
                $this->setColumns(['A' => 1, 'B' => 20, 'C' => 29, 'D' => 50]);
                $this->sheet->getStyle($this->columns[0]."1:".$this->lastColumn."1000")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $this->certificatesWorkerTwo();
                $this->title = 'Удостоверения о профессии рабочего '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
                break;
            case('po'):
                $this->setColumns(['A' => 20, 'AI' => 20]);
                $this->po();
                $this->title = 'Реестр ПО '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
                break;
            case('dpo'):
                $this->setColumns(['A' => 20, 'AN' => 20]);
                $this->dpo();
                $this->title = 'Реестр ДПО '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
                break;
            case('diary_pp'):
                $this->setColumns(['A' => 7, 'B' => 13, 'C' => 60, 'D' => 20]);
                $this->diary_pp();
                $this->title = 'Дневник практики ПП '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
                break;
            case('diary_po'):
                $this->setColumns(['A' => 100]);
                $this->diary_po();
                $this->title = 'Дневник практики ПО '.$this->group->contractor->short_name." ".$this->group->created_at->format('d-m-Y');
                break;
            default:
                return back()->with('error', 'Ошибка при генерации документа');
        endswitch;
        if(!in_array($type, ['pdo', 'do'])):
            $this->sheet->getPageSetup()->setOrientation($orientation)->SetPaperSize(PageSetup::PAPERSIZE_A4)
                ->setPrintArea("A1:$this->lastColumn"."$this->index")->setFitToWidth(1)->setFitToHeight(0);
        else:
            $this->sheet->getPageSetup()->setOrientation($orientation)->SetPaperSize(PageSetup::PAPERSIZE_A4)
                ->setPrintArea("A1:AI"."$this->index")->setFitToWidth(0)->setFitToHeight(0);
        endif;

    }

    private function diary_pp(){
        foreach($this->group->users as $i => $user):

            $this->header("Дневник стажировки курсов профпереподготовки\r\n слушателя ООО «ТУЦ»", 18, true);
            $this->sheet->getRowDimension($this->index - 1)->setRowHeight(50);
            $this->index++;
            $this->index++;
            $this->bold()->center();
            $this->paragraph($user->last_name." ".$user->name." ".$user->patronymic, 20);

            $this->caption('(фамилия, имя, отчество слушателя)');
            $this->index++;
            $this->paragraph("Наименование программы: ".($this->course ? $this->course->title : '__________________________________________________'), 50);
            $this->caption('(наименование программы)');
            $this->index++;
            $this->paragraph("Квалификация (сфера деятельности): ".($this->direction ? $this->direction->title : '__________________________________________________'), 20);
            $this->caption('(наименование квалификации)');
            $this->index++;
            $this->paragraph("Место проведения стажировки: ".$this->group->contractor->name, 20);
            $this->caption('(наименование организации)');
            $this->index++;
            $this->paragraph("Руководитель стажировки: __________________________________________________", 20);
            $this->caption('(фамилия, имя, отчество руководителя стажировки, должность)');
            $this->index++;
            $this->paragraph("Начало практической стажировки «___» ________________202__г", 20);
            $this->index++;
            $this->paragraph("Окончание практической стажировки «___» _______________202__г", 20);
            $this->index++;
            $this->header("Программа стажировки", 14, true);
            $this->index++;
            $this->size(12);
            $this->tablerow(["A" => "Дата", "B" => "Кол-во\r\nчасов", "C" => "Краткая характеристика вида работ", "D" => "Подпись\r\nруководителя\r\nработ"], 1);
            foreach(range(0, 6) as $z):
                $this->tablerow(["A" => "", "B" => "", "C" => "", "D" => ""], 0);
            endforeach;
            $this->index+=5;
            $this->paragraph("Руководитель стажировки: _____________/____________________________________", 20);
            $this->index++;
            $this->paragraph("Руководитель организации: _____________/___________________________________", 20);
            $this->index++;
            $this->paragraph("М.П.", 20);
            $this->index++;

            if($this->group->users->count() - 1 <> $i):
                $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                $this->index++;
            endif;
        endforeach;

    }

    private function diary_po(){
        foreach($this->group->users as $i => $user):

            $this->header("Дневник практической подготовки (практики)\r\n слушателя ООО «ТУЦ»", 18, true);
            $this->sheet->getRowDimension($this->index - 1)->setRowHeight(50);
            $this->index++;
            $this->index++;
            $this->bold()->center();
            $this->paragraph($user->last_name." ".$user->name." ".$user->patronymic, 20);

            $this->caption('(фамилия, имя, отчество слушателя)');
            $this->index++;
            $this->paragraph("Профессия/Должность: ".($this->course ? $this->course->title : '__________________________________________________'), 50);
            $this->caption('(наименование профессии/должности)');
            $this->index++;
            $this->paragraph("Уровень квалификации: _____________________________________________________", 20);
            $this->caption('(разряд, уровень)');
            $this->index++;
            $this->paragraph("Место проведения практической подготовки (практики): ".$this->group->contractor->name, 20);
            $this->caption('(наименование организации)');
            $this->index++;
            $this->paragraph("Мастер: ____________________________________________________________________", 20);
            $this->caption('(фамилия, имя, отчество мастера, должность)');
            $this->index++;

            $this->paragraph("Начало практической подготовки (практики) «___» ________________202__г", 20);
            $this->index++;
            $this->paragraph("Окончание практической подготовки (практики) «___» _______________202__г", 20);
            $this->index++;
            $this->paragraph("Характеристика выполненных работ____________________________________________", 20);
            $this->paragraph("____________________________________________________________________________", 20);
            $this->paragraph("____________________________________________________________________________", 20);
            $this->index+=4;
            $this->paragraph("Мастер: _____________/______________________________________________________", 20);
            $this->index++;
            $this->paragraph("Руководитель организации: _____________/_____________________________________", 20);
            $this->index++;
            $this->paragraph("М.П.", 20);
            $this->index++;

            if($this->group->users->count() - 1 <> $i):
                $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                $this->index++;
            endif;
        endforeach;
    }

    private function dpo(){
        $headers = ['A' => 'Вид документа',
            'B' => 'Статус документа',
            'C' => 'Подтверждение утраты',
            'D' => 'Подтверждение обмена',
            'E' => 'Подтверждение уничтожения',
            'F' => 'Серия документа',
            'G' => 'Номер документа',
            'H' => 'Дата выдачи документа',
            'I' => 'Регистрационный номер',
            'J' => 'Дополнительная профессиональная программа (повышение квалификации/ профессиональная переподготовка)',
            'K' => 'Наименование дополнительной профессиональной программы',
            'L' => 'Наименование области профессиональной деятельности',
            'M' => 'Укрупненные группы специальностей',
            'N' => 'Наименование квалификации, профессии, специальности',
            'O' => 'Уровень образования ВО/СПО',
            'P' => 'Фамилия указанная в дипломе о ВО или СПО',
            'Q' => 'Серия документа о ВО/СПО',
            'R' => 'Номер документа о ВО/СПО',
            'S' => 'Год начала обучения (для документа о квалификации)',
            'T' => 'Год окончания обучения (для документа о квалификации)',
            'U' => 'Срок обучения, часов (для документа о квалификации)',
            'V' => 'Фамилия получателя',
            'W' => 'Имя получателя',
            'X' => 'Отчество получателя',
            'Y' => 'Дата рождения получателя',
            'Z' => 'Пол получателя',
            'AA' => 'СНИЛС',
            'AB' => 'Форма обучения',
            'AC' => 'Источник финансирования обучения',
            'AD' => 'Форма получения образования на момент прекращения образовательных отношений',
            'AE' => 'Гражданство получателя (код страны по ОКСМ)',
            'AF' => 'Наименование документа об образовании (оригинала)',
            'AG' => 'Серия (оригинала)',
            'AH' => 'Номер (оригинала)',
            'AI' => 'Регистрационный N (оригинала)',
            'AJ' => 'Дата выдачи (оригинала)',
            'AK' => 'Фамилия получателя (оригинала)',
            'AL' => 'Имя получателя (оригинала)',
            'AM' => 'Отчество получателя (оригинала)',
            'AN' => 'Номер документа для изменения'];
        $this->sheet->getStyle("A1:AN100")->getAlignment()->setWrapText(true)->setVertical('top')->setHorizontal('center');
        $this->sheet->getStyle("A1:AN100")->getFont()->setName("Times New Roman")->setSize(12);
        foreach($headers as $column => $header):
            $this->sheet->setCellValue($column."1", $header);
            $this->sheet->getColumnDimension($column)->setWidth(20);
        endforeach;

        foreach($this->group->users as $i => $user):
            $this->index++;
            $this->sheet->setCellValue("F$this->index", $user->doc_series);
            $this->sheet->setCellValue("G$this->index", $user->document);
            $this->sheet->setCellValue("K$this->index", $this->course ? $this->course->title : '-');
            $this->sheet->setCellValue("S$this->index", $this->group->start_date ? $this->group->start_date->format('Y') : '-' );
            $this->sheet->setCellValue("T$this->index", $this->group->end_date ? $this->group->end_date->format('Y') : '-' );
            $this->sheet->setCellValue("U$this->index", $this->course ? $this->course->length : '-');
            $this->sheet->setCellValue("V$this->index", $user->last_name);
            $this->sheet->setCellValue("W$this->index", $user->name);
            $this->sheet->setCellValue("X$this->index", $user->patronymic);
            $this->sheet->setCellValue("Y$this->index", $user->birth_date ? $user->birth_date->format('d.m.Y') : '-');
            $this->sheet->setCellValue("Z$this->index", $user->gender);
            $this->sheet->setCellValue("AA$this->index", $user->snils);
            $this->sheet->setCellValue("AK$this->index", $user->last_name);
            $this->sheet->setCellValue("AL$this->index", $user->name);
            $this->sheet->setCellValue("AM$this->index", $user->patronymic);
        endforeach;

    }

    private function po(){
        $headers = [
            'A' => 'Вид документа',
            'B' => 'Статус документа',
            'C' => 'Подтверждение утраты',
            'D' => 'Подтверждение обмена',
            'E' => 'Подтверждение уничтожения',
            'F' => 'Серия документа',
            'G' => 'Номер документа',
            'H' => 'Дата выдачи документа',
            'I' => 'Регистрационный номер',
            'J' => 'Программа профессионального обучения, направление подготовки',
            'K' => 'Наименование программы профессионального обучения',
            'L' => 'Наименование профессий рабочих, должностей служащих',
            'M' => 'Присвоенный квалификационный разряд, класс, категория (при наличии)',
            'N' => 'Год начала обучения',
            'O' => 'Год окончания обучения',
            'P' => 'Срок обучения, часов',
            'Q' => 'Фамилия получателя',
            'R' => 'Имя получателя',
            'S' => 'Отчество получателя',
            'T' => 'Дата рождения получателя',
            'U' => 'Пол получателя',
            'V' => 'СНИЛС',
            'W' => 'Гражданство получателя (код страны по ОКСМ)',
            'X' => 'Форма обучения',
            'Y' => 'Источник финансирования обучения',
            'Z' => 'Форма получения образования на момент прекращения образовательных отношений',
            'AA' => 'Наименование документа об образовании (оригинала)',
            'AB' => 'Серия (оригинала)',
            'AC' => 'Номер (оригинала)',
            'AD' => 'Регистрационный N (оригинала)',
            'AE' => 'Дата выдачи (оригинала)',
            'AF' => 'Фамилия получателя (оригинала)',
            'AG' => 'Имя получателя (оригинала)',
            'AH' => 'Отчество получателя (оригинала)',
            'AI' => 'Номер документа для изменения',
        ];
        $this->sheet->getStyle("A1:AI100")->getAlignment()->setWrapText(true)->setVertical('top')->setHorizontal('center');
        $this->sheet->getStyle("A1:AI100")->getFont()->setName("Times New Roman")->setSize(12);
        foreach($headers as $column => $header):
            $this->sheet->setCellValue($column."1", $header);
            $this->sheet->getColumnDimension($column)->setWidth(20);
        endforeach;

        foreach($this->group->users as $i => $user):
            $this->index++;
            #$this->sheet->setCellValue("F$this->index", $user->doc_series);
            $this->sheet->setCellValue("G$this->index", $user->document);
            $this->sheet->setCellValue("K$this->index", $this->course ? $this->course->title : '-');
            $this->sheet->setCellValue("N$this->index", $this->group->start_date ? $this->group->start_date->format('Y') : '-' );
            $this->sheet->setCellValue("O$this->index", $this->group->end_date ? $this->group->end_date->format('Y') : '-' );
            $this->sheet->setCellValue("Q$this->index", $user->last_name);
            $this->sheet->setCellValue("R$this->index", $user->name);
            $this->sheet->setCellValue("S$this->index", $user->patronymic);
            $this->sheet->setCellValue("T$this->index", $user->birth_date ? $user->birth_date->format('d.m.Y') : '-');
            $this->sheet->setCellValue("U$this->index", $user->gender);
            $this->sheet->setCellValue("V$this->index", $user->snils);
            $this->sheet->setCellValue("AF$this->index", $user->last_name);
            $this->sheet->setCellValue("AG$this->index", $user->name);
            $this->sheet->setCellValue("AH$this->index", $user->patronymic);
        endforeach;
    }

    private function agreements(){
        foreach($this->group->users as $i => $user):
            $this->sheet->setCellValue("A$this->index", "Приложение № 2");
            $this->sheet->getStyle("A$this->index")->getFont()->setBold(true);
            $this->sheet->getStyle("A$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $this->index++;
            $this->sheet->setCellValue("A$this->index", "К договору № ".$this->group->contract." от ".($this->group->start_date ? $this->group->start_date->format('d.m.Y') : "___________")."\r\nДиректору ООО «ТУЦ»r\r\nЕ.В. Евграфовой");
            $this->sheet->getStyle("A$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $this->index++;
            $this->delimeter();
            $this->sheet->setCellValue("A$this->index","Согласие\r\n на обработку персональных данных обучающегося\r\nпо программе дополнительного профессионального образования");
            $this->sheet->getStyle("A$this->index")->getFont()->setBold(true);
            $this->sheet->getStyle("A$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $this->index++;
            $this->delimeter();
            $this->sheet->setCellValue("A$this->index", "Я, ".$user->last_name." ".$user->name." ".$user->patronymic);
            $this->index++;
            $this->sheet->setCellValue("A$this->index","(фамилия, имя, отчество (при наличии) полностью)");
            $this->sheet->getStyle("A$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(8);

            $this->index++;
            $this->delimeter();
            $this->sheet->setCellValue("A$this->index","Зарегистрированный по адресу: ______________________________________________");
            $this->index++;
            $this->sheet->setCellValue("A$this->index","(индекс, город, улица,  номер дома корпуса, кв при наличии)");
            $this->sheet->getStyle("A$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(8);
            $this->index++;
            $this->delimeter();
            $this->sheet->setCellValue("A$this->index", "Документ, удостоверяющий личность: ".($user->document ? ("паспорт серия ".$user->doc_series." №".$user->document) : '________________________________________'));
            $this->index++;
            $this->sheet->setCellValue("A$this->index","(серия, номер, кем когда выдан)");
            $this->sheet->getStyle("A$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(8);
            $this->index++;
            $this->delimeter();

            $this->sheet->setCellValue("A$this->index", "Номер телефона: ".$user->phone);
            $this->sheet->setCellValue("A$this->index","в соответствии с Федеральным законом от 27.07.2006 № 152-ФЗ \"О персональных данных\" и письмом Рособразования от 29.07.2009 № 17-110 \"Об обеспечении защиты персональных данных\" даю согласие на обработку моих персональных данных Общество с ограниченной ответственностью «Тюменский Учебный Центр»  (далее - ООО «ТУЦ»), расположенному по адресу 625023, РФ, Тюменская область, г. Тюмень, ул. Республики, дом 209, оф.300");
            $this->index++;
            $this->delimeter();
            $this->subheader("Цель обработки персональных данных:");
            $this->delimeter();
            $this->listItem("целью обработки персональных данных является организация и сопровождение учебного\r\nпроцесса,");
            $this->listItem("обеспечение соблюдения федерального и регионального законодательства Конституции Российской Федерации,");
            $this->listItem("содействие в освоении образовательных программ;");
            $this->listItem("учет выполнения учебного плана и качества полученных знаний;");
            $this->listItem("формирование, ведение делопроизводства и документооборота, в том числе в электронном виде;");
            $this->listItem("обеспечение личной безопасности в период обучения.");
            $this->delimeter();
            $this->subheader("Перечень персональных данных, на обработку которых дается согласие:");
            $this->delimeter();
            $this->listItem("фамилия, имя, отчество (при наличии) (в том числе предыдущие фамилии, имена, отчества (при наличии) в случае их изменения); ");
            $this->listItem("пол;");
            $this->listItem("год рождения;");
            $this->listItem("вид, серия, номер документа, удостоверяющего личность, наименование органа, выдавшего его, дата выдачи, его копия (при необходимости);");
            $this->listItem("гражданство; ");
            $this->listItem("контактные данные (номер телефона, адрес электронной почты); ");
            $this->listItem("сведения о предыдущем образовании (уровень образования, подуровень образования, специальность по диплому, категория квалификации, наименование образовательного учреждения, дата окончания, серия и номер документа об образовании, форма обучения), копии документов об образовании (при необходимости);");
            $this->listItem("сведения о трудоустройстве (квалификация, стаж, общий стаж, стаж непрерывный, предметы, сведения о работодателе (текущее место работы), вид работы, ");
            $this->listItem("дата последней аттестации, должность;");
            $this->listItem("сведения о повышении квалификации, профессиональной переподготовке (наименование образовательной программы, объем, начало (окончание) обучения, профессия, квалификация;");
            $this->listItem("фотография (при необходимости);");
            $this->listItem("СНИЛС;");
            $this->listItem("сведения о договоре об оказании образовательных услуг для обучающихся (слушателей), обучающихся за счет средств юридических лиц.");
            $this->delimeter();
            $this->subheader("Перечень действий с персональными данными, на совершение которых дается согласие, общее описание используемых оператором способов обработки:");
            $this->delimeter();
            $this->listItem("сбор");
            $this->listItem("систематизация");
            $this->listItem("накопление");
            $this->listItem("хранение персональных данных (в электронном виде и (или) бумажном носителе)");
            $this->listItem("уточнение (обновление, изменение)");
            $this->listItem("передача (распространение, предоставление, доступ), обезличивание, блокирование, уничтожение персональных данных");
            $this->delimeter();
            $this->sheet->setCellValue("A$this->index", "    Данное согласие распространяется на автоматизированную и неавтоматизированную обработку персональных данных. Кроме того, даю согласие считать мои фамилию, имя, отчество (при наличии), форму обучения, направление подготовки, результаты зачисления, информацию о прохождении учебного процесса и его результатах общедоступными персональными данными.");
            $this->index++;
            $this->delimeter();
            $this->sheet->setCellValue("A$this->index", "    Согласие на обработку персональных данных действует в течение срока обучения и на период хранения документов согласно действующему законодательству Российской Федерации. ");
            $this->index++;
            $this->delimeter();
            $this->subheader("Порядок отзыва согласия:");
            $this->delimeter();
            $this->sheet->setCellValue("A$this->index", "    Данное мною согласие может быть отозвано в любой момент с обязательным направлением Оператору письменного уведомления.");
            $this->index++;
            $this->sheet->setCellValue("A$this->index", "    С момента получения уведомления об отзыве согласия на обработку персональных данных, а также при прекращении обучения Оператор обязан прекратить обработку персональных данных, указанных в настоящем Согласии, и (или) уничтожить персональные данные в течение трех рабочих дней с момента получения отзыва. Требование об уничтожении не распространяется на персональные данные, для которых нормативными правовыми актами предусмотрена обязанность ее хранения, в том числе после прекращения отношений в области образования. При достижении целей обработки персональные данные подлежат уничтожению по истечении одного месяца с даты достижения таких целей.");
            $this->index++;
            $this->delimeter();
            $this->sheet->setCellValue("A$this->index", "    Мне разъяснено, что для обработки персональных данных, содержащихся в настоящем Согласии, моего дополнительного согласия не требуется. ");
            $this->index++;
            $this->delimeter();
            $this->sheet->setCellValue("A$this->index", "    Я ознакомлен с Положением об обработке и защите персональных данных обучающихся ООО «ТУЦ»");
            $this->index++;
            $this->index++;
            $this->sheet->setCellValue("A$this->index", "_______________ / ".$user->last_name." ".mb_substr($user->name, 0, 1).". ".mb_substr($user->patronymic, 0, 1)."."." / «____» __________ ".date('Y')." г.");
            $this->index++;
            $this->sheet->setCellValue("A$this->index","      (подпись)            (расшифровка)");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(8);
            if($this->group->users->count() - 1 <> $i):
                $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                $this->index++;
            endif;
        endforeach;
    }

    private function certificatesWorkerTwo(){
        foreach($this->group->users as $i => $user):
            $this->sheet->getRowDimension($this->index)->setRowHeight(5);
            $this->sheet->getStyle('A'.$this->index.':D'.$this->index)->getBorders()->getTop()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('#000'));
            $start = $this->index;
            $this->index++;
            $this->sheet->mergeCells("B$this->index:B".($this->index+9));
            $this->sheet->getStyle("B$this->index:B".($this->index+9))->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('FF008000'));
            $this->sheet->setCellValue("D$this->index", "Удостоверение № ___");
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(12)->setBold(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(20);
            $this->index++;
            $this->delimeter();
            $rte = new RichText();
            $run = $rte->createTextRun('Выдано ');
            $run->getFont()->setName("Times New Roman")->setSize(10);
            $run = $rte->createTextRun(\morphos\Russian\inflectName($user->last_name." ".$user->name." ".$user->patronymic, 'дательный'));
            $run->getFont()->setUnderline(true)->setName("Times New Roman")->setSize(10)->setBold(true);
            $this->sheet->getCell("D".$this->index)->setValue($rte);
            $this->sheet->setCellValue("C$this->index", '＿＿＿＿＿＿＿＿＿');
            $this->sheet->getRowDimension($this->index)->setRowHeight(15);
            $this->index++;

            $this->sheet->getRowDimension($this->index)->setRowHeight(12);
            $this->sheet->setCellValue("C$this->index", '(личная подпись)');
            $this->sheet->setCellValue("D$this->index", '        (фамилия, имя, отчество)');
            $this->sheet->getStyle("C$this->index:D$this->index")->getFont()->setSize(8);
            $this->sheet->getStyle("D$this->index")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            $this->index++;
            $this->delimeter();
            $this->sheet->setCellValue("D$this->index", 'в том, что он(а) '.$this->endDate.' г. завершил(а) обучение в');
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(10);
            $this->index++;
            $this->delimeter();
            $this->sheet->setCellValue("D$this->index", "Обществе с ограниченной ответственностью\r\n«Тюменский Учебный Центр»");
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(10)->setBold(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(30);
            $this->index++;
            $this->sheet->setCellValue("D$this->index", "(ООО «ТУЦ»)");
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(10);
            $this->index++;
            $this->sheet->setCellValue("C$this->index", '  М.П.');
            $this->sheet->getStyle("C$this->index")->getFont()->setSize(10);
            $this->sheet->getStyle("C$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $this->sheet->getRowDimension($this->index)->setRowHeight(10);
            $this->index++;
            $this->sheet->setCellValue("D$this->index", 'по профессии');
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(10);
            $this->index++;
            $this->delimeter();
            $this->sheet->mergeCells("B$this->index:C$this->index");
            $this->sheet->setCellValue("B$this->index", 'Выдано '.$this->endDate.' г.');
            $this->sheet->setCellValue("D$this->index", $this->course ? $this->course->title : '____________');
            $this->sheet->getStyle("B$this->index:D$this->index")->getFont()->setSize(10)->setBold(true);
            $this->index++;
            $this->sheet->getStyle("A$start:A$this->index")->getBorders()->getLeft()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('#000'));
            $this->sheet->getStyle("D$start:D$this->index")->getBorders()->getRight()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('#000'));
            $this->sheet->getStyle('A'.$this->index.':D'.$this->index)->getBorders()->getBottom()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('#000'));
            $this->sheet->getRowDimension($this->index)->setRowHeight(10);

            $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
            $this->index++;


            // Второй лист
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "Решением квалификационной комиссии");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(12)->setBold(true);
            $this->index++;
            $this->delimeter();
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", \morphos\Russian\inflectName($user->last_name." ".$user->name." ".$user->patronymic, 'дательный'));
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(10)->setUnderline(true)->setBold(true);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->getRowDimension($this->index)->setRowHeight(12);
            $this->sheet->setCellValue("A$this->index", '(Фамилия, имя, отчество)');
            $this->sheet->getStyle("A$this->index")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(8);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", 'Присвоена квалификация:');
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(10);
            $this->sheet->getRowDimension($this->index)->setRowHeight(20);
            $this->index++;
            $this->delimeter();
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", $this->course ? $this->course->title : '____________');
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(10)->setBold(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(30);
            $this->index++;
            $this->delimeter();
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", 'Допускается к выполнению работ как:');
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(10);
            $this->sheet->getRowDimension($this->index)->setRowHeight(20);
            $this->index++;
            $this->delimeter();
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", $this->course ? $this->course->title : '____________');
            $this->sheet->getRowDimension($this->index)->setRowHeight(30);
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(10)->setBold(true);
            $this->index++;
            $this->sheet->getRowDimension($this->index)->setRowHeight(400);
            $this->index++;
            $this->sheet->getStyle('A'.$this->index.':D'.$this->index)->getBorders()->getTop()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('#000'));
            $start = $this->index;
            $this->sheet->getRowDimension($this->index)->setRowHeight(10);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "Основание:");
            $this->sheet->setCellValue("D$this->index", "Основание:");
            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(12)->setBold(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(30);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $text = "протокол квалификационной комиссии\r\n № 0".$this->group->protocol." / ".$this->group->number." от ".$this->group->end_date->format('d.m.Y');
            $this->sheet->setCellValue("A$this->index", $text);
            $this->sheet->setCellValue("D$this->index", $text);
            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(10);
            $this->sheet->getRowDimension($this->index)->setRowHeight(30);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "  Председатель\r\n  квалификационной комиссии ____________  ".$this->group->chairman2);
            $this->sheet->setCellValue("D$this->index", "  Председатель\r\n  квалификационной комиссии ____________  ".$this->group->chairman2);
            $this->sheet->getStyle("A$this->index:D$this->index")->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM)->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $this->sheet->getRowDimension($this->index)->setRowHeight(30);

            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(10);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", '    (подпись)');
            $this->sheet->setCellValue("D$this->index", '    (подпись)');
            $this->sheet->getRowDimension($this->index)->setRowHeight(12);
            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(8);
            $this->sheet->getStyle("A$this->index:D$this->index")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "  Секретарь __________________________   ".$this->group->secretary);
            $this->sheet->setCellValue("D$this->index", "  Секретарь __________________________   ".$this->group->secretary);
            $this->sheet->getStyle("A$this->index:D$this->index")->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM)->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $this->sheet->getRowDimension($this->index)->setRowHeight(30);

            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(10);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", '(подпись)');
            $this->sheet->setCellValue("D$this->index", '(подпись)');
            $this->sheet->getRowDimension($this->index)->setRowHeight(12);
            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(8);
            $this->sheet->getStyle("A$this->index:D$this->index")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);


            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "  Директор __________________________   ".$this->director);
            $this->sheet->setCellValue("D$this->index", "  Директор __________________________   ".$this->director);
            $this->sheet->getStyle("A$this->index:D$this->index")->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM)->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $this->sheet->getRowDimension($this->index)->setRowHeight(30);

            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(10);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", '(подпись)');
            $this->sheet->setCellValue("D$this->index", '(подпись)');
            $this->sheet->getRowDimension($this->index)->setRowHeight(12);
            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(8);
            $this->sheet->getStyle("A$this->index:D$this->index")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", 'М.П.');
            $this->sheet->setCellValue("D$this->index", 'М.П.');
            $this->sheet->getRowDimension($this->index)->setRowHeight(20);
            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(10);
            $this->index++;
            $this->sheet->getRowDimension($this->index)->setRowHeight(10);

            $this->sheet->getStyle("A$start:A$this->index")->getBorders()->getLeft()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('#000'));
            $this->sheet->getStyle("D$start:D$this->index")->getBorders()->getRight()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('#000'));
            $this->sheet->getStyle("D$start:D$this->index")->getBorders()->getLeft()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('#000'));
            $this->sheet->getStyle('A'.$this->index.':D'.$this->index)->getBorders()->getBottom()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('#000'));
            $this->index++;
            $this->sheet->getRowDimension($this->index)->setRowHeight(10);

            if($this->group->users->count() - 1 <> $i):
                $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                $this->index++;
            endif;

        endforeach;

    }

    private function certificatesWorker(){
        foreach($this->group->users as $i => $user):

            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("A$this->index", "Общество с ограниченной ответственностью\r\n«Тюменский Учебный Центр»");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(12)->setBold(true);
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("D$this->index", 'Настоящее свидетельство подтверждает, что');
            $this->sheet->getStyle("D$this->index")->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(14);
            $this->sheet->getRowDimension($this->index)->setRowHeight(40);

            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("A$this->index", "Лицензия  на осуществление  образовательной деятельности №017 от 18 апреля 2019 г., выдана Департаментом  образования и науки Тюменской области");
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("D$this->index", $user->last_name." ".$user->name." ".$user->patronymic);
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(16)->setBold(true);
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(9)->setItalic(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(25);
            $this->index++;
            $drawing = new Drawing();
            $drawing->setPath(public_path('images/logo.png'))->setCoordinates('B'.$this->index)->setOffsetX(0)
                ->setOffsetY(25)->setWidth(130)->setHeight(130)->setWorksheet($this->sheet);
            $this->index++;


            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("D$this->index", 'с '.$this->startDate.' года по '.$this->endDate.' года');
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(12);
            $this->index++;

            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("D$this->index", "освоил(а) программу профессиональной подготовки в\r\nОбществе с ограниченной ответственностью\r\n«Тюменский Учебный Центр»\r\n(ООО «ТУЦ»)");
            $this->sheet->getRowDimension($this->index)->setRowHeight(90);
            $this->index++;

            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", 'СВИДЕТЕЛЬСТВО');
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(26)->setBold(true);
            $this->sheet->mergeCells("D$this->index:F".($this->index+1));
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(14)->setBold(true);
            $this->sheet->setCellValue("D$this->index", "По профессии\r\n«".($this->course ? $this->course->title : "____________").'»'.
                "\r\nВ объёме ".($this->course ? $this->course->length : "___")." ч.");
            $this->sheet->getRowDimension($this->index)->setRowHeight(40);

            $this->index++;
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(14)->setBold(true);
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "О ПРОФЕССИИ РАБОЧЕГО\r\nДОЛЖНОСТИ СЛУЖАЩЕГО");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(12)->setBold(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(60);
            $this->index++;


            $this->index++;

            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("D$this->index", "Решением квалификационной комиссии от ".$this->startDate." года протокол ".$this->group->protocol." / ".$this->group->number." присвоена квалификация");
            $this->sheet->getRowDimension($this->index)->setRowHeight(80);
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "СПР ??????");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(13)->setBold(true)->setColor(new Color('Red'));
            $this->index++;
            $this->sheet->mergeCells("D$this->index:F".($this->index+3));
            $this->sheet->setCellValue("D$this->index", "«".($this->course ? $this->course->title : "____________")."»");
            $this->sheet->getStyle("A$this->index:D$this->index")->getFont()->setSize(14)->setBold(true);
            $this->bigDelimeter();

            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "Документ о квалификации ");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(12)->setBold(true);
            $this->index++;

            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "Регистрационный номер ____");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(12)->setBold(true);
            $this->index++;

            $this->sheet->setCellValue("E$this->index", "Председатель\r\nКвалификационной комиссии");
            $this->sheet->getStyle("E$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_BOTTOM);
            $this->sheet->setCellValue("F$this->index", $this->group->chairman2);
            $this->sheet->getStyle("F$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_BOTTOM);

            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "Дата выдачи ".$this->endDate." года");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(11);
            $this->sheet->setCellValue("D$this->index", "М.П.     ");
            $this->sheet->getStyle("D$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $this->index++;

            $this->sheet->setCellValue("E$this->index", "Руководитель\r\nобразовательной организации");
            $this->sheet->getStyle("E$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_BOTTOM);
            $this->sheet->setCellValue("F$this->index", $this->director);
            $this->sheet->getStyle("F$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_BOTTOM);
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "Город Тюмень");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(11)->setBold(true);

            if($this->group->users->count() - 1 <> $i):
                $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                $this->index++;
            endif;
        endforeach;

    }

    private function createCertificatesPrint(){
        foreach($this->group->users as $i => $user):
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("A$this->index", "Общество с ограниченной ответственностью\r\n«Тюменский Учебный Центр»");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(12)->setBold(true);
            $this->sheet->setCellValue("D$this->index", 'УДОСТОВЕРЕНИЕ');
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(24)->setBold(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(35);

            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("A$this->index", "Лицензия  на осуществление  образовательной деятельности №017 от 18 апреля 2019 г., выдана Департаментом  образования и науки Тюменской области");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(9)->setItalic(true);
            $this->sheet->setCellValue("D$this->index", 'О ПОВЫШЕНИИ КВАЛИФИКАЦИИ');
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(16)->setBold(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(23);
            $this->index++;
            $this->bigDelimeter();
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("D$this->index", 'Настоящее удостоверение подтверждает, что');
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(12);
            $this->index++;
            $drawing = new Drawing();
            $drawing->setPath(public_path('images/logo.png'))->setCoordinates('B'.$this->index)->setOffsetX(10)
                ->setOffsetY(10)->setWidth(200)->setHeight(200)->setWorksheet($this->sheet);
            $this->bigDelimeter();
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("D$this->index", $user->last_name." ".$user->name." ".$user->patronymic);
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(16)->setBold(true)->setUnderline(true);
            $this->index++;
            $this->bigDelimeter();
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("D$this->index", 'В период с '.$this->startDate.' года по '.$this->endDate.' года');
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(12);
            $this->index++;
            $this->bigDelimeter();
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->setCellValue("D$this->index", "прошел(а) повышения квалификации в\r\nООО «Тюменский Учебный Центр»\r\nпо программе дополнительного\r\nпрофессионального образования");
            $this->sheet->getRowDimension($this->index)->setRowHeight(70);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "Удостоверение является документом установленного образца о повышении квалификации");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(10)->setItalic(true);
            $this->bigDelimeter();
            $this->sheet->mergeCells("D$this->index:F$this->index");

            $this->sheet->setCellValue("D$this->index", "«".($this->course ? $this->course->title : "____________").'»');
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(14)->setBold(true);
            $this->index++;
            $this->bigDelimeter();
            $this->sheet->mergeCells("D$this->index:F$this->index");
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "КПК ??????");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(11)->setBold(true);
            $this->sheet->setCellValue("D$this->index", "В объёме ".($this->course ? $this->course->length : "___")." ч.");
            $this->sheet->getStyle("D$this->index")->getFont()->setSize(12)->setBold(true);
            $this->index++;
            $this->bigDelimeter();
            $this->sheet->setCellValue("D$this->index", "М.П.     ");
            $this->sheet->getStyle("D$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $this->sheet->setCellValue("E$this->index", "Директор");
            $this->sheet->setCellValue("F$this->index", $this->director);
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "Дата выдачи ".$this->endDate." года");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(11)->setBold(true);
            $this->index++;
            $this->bigDelimeter();
            $this->sheet->setCellValue("E$this->index", "Секретарь");
            $this->sheet->setCellValue("F$this->index", $this->group->secretary);
            $this->sheet->mergeCells("A$this->index:C$this->index");
            $this->sheet->setCellValue("A$this->index", "Город Тюмень");
            $this->sheet->getStyle("A$this->index")->getFont()->setSize(11)->setBold(true);
            if($this->group->users->count() > $i):
                $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                $this->index++;
            endif;
        endforeach;

    }

    private function createCertificates(){
        foreach($this->group->users as $i => $user):
            $this->line();
            $drawing = new Drawing();
            $drawing->setPath(public_path('images/logo.png'))->setCoordinates('A'.$this->index)->setOffsetX(5)
                ->setOffsetY(10)->setWidth(80)->setHeight(80)->setWorksheet($this->sheet);
            $this->sheet->setCellValue("B$this->index", 'Общество с ограниченной ответственностью');
            $style = $this->sheet->getStyle("B$this->index");
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $style->getFont()->setSize(9)->setBold(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(12);
            $this->index++;
            $treshold = $this->index;
            $this->sheet->setCellValue("B$this->index", '«Тюменский Учебный Центр»');
            $style = $this->sheet->getStyle("B$this->index");
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $style->getFont()->setSize(10)->setBold(true);
            $this->sheet->getRowDimension($this->index)->setRowHeight(12);
            $this->index++;
            $this->sheet->setCellValue("B$this->index", 'Лицензия  на осуществление  образовательной деятельности №017 от 18 апреля 2019 г., выдана Департаментом  образования и науки Тюменской области');
            $style = $this->sheet->getStyle("B$this->index");
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $style->getFont()->setSize(9);
            $this->sheet->getRowDimension($this->index)->setRowHeight(50);
            $this->index++;
            $this->sheet->setCellValue("B$this->index", 'УДОСТОВЕРЕНИЕ № ??????');
            $style = $this->sheet->getStyle("B$this->index");
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $this->sheet->getRowDimension($this->index)->setRowHeight(15);
            $style->getFont()->setSize(11)->setBold(true);
            $this->index++;
            $this->sheet->setCellValue("A$this->index", 'Фамилия');
            $this->sheet->setCellValue("B$this->index", "          ".$user->last_name);
            $this->sheet->getRowDimension($this->index)->setRowHeight(14);
            $this->index++;
            $this->sheet->setCellValue("A$this->index", 'Имя');
            $this->sheet->setCellValue("B$this->index", "          ".$user->name);
            $this->sheet->getRowDimension($this->index)->setRowHeight(14);
            $this->index++;
            $this->sheet->setCellValue("A$this->index", 'Отчество');
            $this->sheet->setCellValue("B$this->index", "          ".$user->patronymic);
            $this->sheet->getRowDimension($this->index)->setRowHeight(14);
            $this->index++;
            $this->sheet->setCellValue("A$this->index", 'Должность (профессия)');
            $this->sheet->setCellValue("B$this->index", "          ".$user->position);
            $style = $this->sheet->getStyle("A".($this->index-4).":B".$this->index);
            $style->getFont()->setSize(9);
            $this->index++;
            $this->sheet->setCellValue("B$this->index", $this->group->contractor->short_name);
            $style = $this->sheet->getStyle("B".$this->index);
            $style->getFont()->setSize(9);
            $this->sheet->getRowDimension($this->index)->setRowHeight(14);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:B$this->index");
            $this->sheet->setCellValue("A$this->index", "Дата выдачи ".($this->group->end_date ? $this->group->end_date->format('d.m.Y') : '')." г.");
            $style = $this->sheet->getStyle("A$this->index");
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $style->getFont()->setSize(8);
            $this->sheet->getRowDimension($this->index)->setRowHeight(12);
            $this->index++;
            $this->sheet->mergeCells("A$this->index:B$this->index");
            $this->sheet->setCellValue("A$this->index", "г. Тюмень");
            $style = $this->sheet->getStyle("A$this->index");
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $style->getFont()->setSize(8);
            $this->sheet->getRowDimension($this->index)->setRowHeight(12);
            if($i > 1 and ($i + 1) % 4 === 0 and $this->group->users->count() !== ($i + 1)):
                $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
            endif;
            $this->index++;

            // Формируем правую часть удостоверения
            $this->sheet->mergeCells("C$treshold:D".($treshold + 5));

            $style = $this->sheet->getStyle("C$treshold:D".($treshold + 1));

            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $rte = new RichText();
            $run = $rte->createTextRun("В период с ".$this->startDate." г. по ".$this->endDate." г. прошел(ла) обучение в объеме соответствующим требованиям программы \r\n");
            $run->getFont()->setSize(9)->setName("Times New Roman");
            $run = $rte->createTextRun("«".($this->course ? $this->course->title : '______________')."»\r\n");
            $run->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED))->setSize(9)->setName("Times New Roman")->setBold(true);
            $run = $rte->createTextRun("Количество часов по программе обучения:".($this->course ? $this->course->length : '___')." часов \r\n");
            $run->getFont()->setSize(9)->setName("Times New Roman");
            $run = $rte->createTextRun("Сдал(а) экзамен с оценкой: хорошо\r\n");
            $run->getFont()->setSize(9)->setName("Times New Roman");
            $run = $rte->createTextRun("Протокол заседания экзаменационной комиссии \r\n");
            $run->getFont()->setSize(9)->setName("Times New Roman");
            $run = $rte->createTextRun($this->group->protocol." / ".$this->group->number." от ".($this->group->end_date ? $this->group->end_date->format('d.m.Y') : '__________')." \r\n");
            $run->getFont()->setSize(9)->setName("Times New Roman");
            $this->sheet->getCell("C".$treshold)->setValue($rte);

            $this->sheet->setCellValue("C".($treshold + 6), 'Председатель экзаменационной комиссии');
            $this->sheet->setCellValue("D".($treshold + 6), $this->group->chairman2);
            $this->sheet->setCellValue("C".($treshold + 7), 'Директор ООО «ТУЦ»');
            $this->sheet->setCellValue("D".($treshold + 7), $this->director);
            $style = $this->sheet->getStyle("D".($treshold + 6).":D".($treshold + 7));
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $style->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
            $style = $this->sheet->getStyle("C".($treshold + 6).":D".($treshold + 7));
            $style->getFont()->setSize(10);
            $this->sheet->mergeCells("C".($treshold + 8).":D".($treshold + 8));
            $this->sheet->setCellValue("C".($treshold + 8), 'М.П.');
            $style = $this->sheet->getStyle("C".($treshold + 8).":D".($treshold + 8));
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $style->getFont()->setSize(10);

        endforeach;
        $this->line();

    }

    private function createCertificatesPK(){
        foreach($this->group->users as $user):
            $this->index+=5;
            $this->sheet->setCellValue("D$this->index", $user->last_name." ".$user->name." ".$user->patronymic);
            $drawing = new Drawing();
            $drawing->setPath(public_path('images/logo.png'))->setCoordinates('B'.$this->index)->setOffsetX(5)
                ->setOffsetY(30)->setWidth(130)->setHeight(130)->setWorksheet($this->sheet);
            $this->sheet->getRowDimension($this->index)->setRowHeight(120);
            $this->index++;
            $this->bigDelimeter();
            $this->sheet->setCellValue("D$this->index", "В период с ".$this->group->created_at->format('d.m.Y')." по __.__".date('Y'));
            $this->bigDelimeter();
            $this->sheet->setCellValue("D$this->index", "«".($this->course ? $this->course->title : '______________')."»");

            $this->bigDelimeter();
            $this->sheet->setCellValue("B$this->index", "0000000");
            $this->sheet->setCellValue("D$this->index", ($this->course ? $this->course->length : '___')." часов");
            $this->bigDelimeter();
            $this->index++;
            $this->sheet->setCellValue("B$this->index", "0000");
            $this->sheet->getRowDimension($this->index)->setRowHeight(20);
            $this->index++;
            $style = $this->sheet->getStyle("A1:D".$this->index);

            $style->getFont()->setBold(true);
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $this->delimeter();
            $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
        endforeach;

    }

    private function createProtocol(){
        $this->setHeaderImage();
        $this->sheet->getRowDimension($this->index)->setRowHeight(150);
        $this->index++;
        $this->header('Протокол № '.$this->group->protocol.' / '.$this->group->number.' заседания экзаменационной комиссии ООО «ТУЦ»', 18, true);
        $this->delimeter();
        $this->dateLine();
        $this->index++;
        $this->paragraph('Комиссией в составе: ', 25);
        $this->delimeter();
        $this->paragraph('Председатель: '.$this->group->chairman_pos.' '.$this->group->chairman, 25);
        $this->delimeter();
        $this->paragraph('Члены комиссии: '.$this->group->member1_pos.' '.$this->group->member1.($this->group->member2 ? ', '.$this->group->member2_pos.' '.$this->group->member2 : ''), 40);
        $this->index++;
        $this->paragraph('проведена проверка знаний слушателей группы № '.$this->group->number.' в объеме, соответствующем требованиям профессионального обучения (повышения квалификации) «'.($this->course ? $this->course->title : "_________").'» '.($this->course ? $this->course->length : "___").' часов', 75);
        $this->delimeter();
        $this->tablerow(['A' => '№ п/п', 'B' => 'Ф.И.О.', 'C' => 'Должность', 'D' => 'Организация', 'E' => 'Результат проверки знаний'], true);
        foreach($this->group->users as $i => $user):
            $this->tablerow(['A' => $i+1, 'B' => $user->last_name." ".$user->name." ".$user->patronymic,
                'C' => $user->position, 'D' => $this->group->contractor->name, 'E' => 'Хорошо'], false);
        endforeach;
        $this->delimeter();
        $this->signature(['Председатель', $this->group->chairman]);
        $this->bigDelimeter();
        $this->signature(['Члены комиссии', $this->group->member1]);
        $this->delimeter();
        $this->signature([' ', $this->group->member2]);
        $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);

        // 2 лист
        $this->index++;
        $this->header('Протокол № '.$this->group->protocol.' / '.$this->group->number.' заседания экзаменационной комиссии ООО «ТУЦ»', 18, true);
        $this->delimeter();
        $this->dateLine();
        $this->index++;
        $this->paragraph('Квалификационная комиссия в составе: ', 25);
        $this->delimeter();
        $this->paragraph('Председатель: '.$this->group->chairman2_pos.' '.$this->group->chairman2, 25);
        $this->delimeter();
        $this->paragraph('Члены комиссии: '.$this->group->member3_pos.' '.$this->group->member3.($this->group->member4 ? ', '.$this->group->member4_pos.' '.$this->group->member4 : ''), 40);
        $this->index++;
        $this->paragraph('Секретарь комиссии: '.$this->group->secretary_pos.' '.$this->group->secretary, 25);
        $this->delimeter();
        $this->paragraph('Обсудив результаты обучения, промежуточной и итоговой аттестации обучающихся по программе профессионального обучения (повышения квалификации)  «'.($this->course ? $this->course->title : "_________").'» ('.($this->course ? $this->course->length : "___").' часов), решила:', 75);
        $this->delimeter();
        $this->paragraph('считать окончившими обучение в ООО «ТУЦ» следующих обучающихся и подтвердившими квалификацию и установленные разряды:', 25);
        $this->tablerow(['A' => '№ п/п', 'B' => 'Ф.И.О.', 'C' => 'Должность', 'D' => 'Разряд', 'E' => 'Результат проверки знаний'], true);
        foreach($this->group->users as $i => $user):
            $this->tablerow(['A' => $i+1, 'B' => $user->last_name." ".$user->name." ".$user->patronymic,
                'C' => $user->position, 'D' => $this->group->contractor->name, 'E' => 'Хорошо'], false);
        endforeach;
        $this->delimeter();
        $this->signature(['Председатель', $this->group->chairman2]);
        $this->bigDelimeter();
        $this->signature(['Члены комиссии', $this->group->member3]);
        $this->delimeter();
        $this->signature([' ', $this->group->member4]);
        $this->bigDelimeter();
        $this->signature(['Секретарь комиссии', $this->group->secretary]);
        $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);

        // 3 лист
        $this->index++;
        $this->header('Выписка из протокола № '.$this->group->protocol.' / '.$this->group->number.' заседания экзаменационной комиссии ООО «ТУЦ»', 18, true);
        $this->delimeter();
        $this->dateLine();
        $this->index++;
        $this->paragraph('Комиссией в составе: ', 25);
        $this->delimeter();
        $this->paragraph('Председатель: '.$this->group->chairman_pos.' '.$this->group->chairman, 25);
        $this->index++;
        $this->paragraph('Члены комиссии: '.$this->group->member1_pos.' '.$this->group->member1.($this->group->member2 ? ', '.$this->group->member2_pos.' '.$this->group->member2 : ''), 40);
        $this->index++;
        $this->paragraph('проведена проверка знаний слушателей группы № '.$this->group->number.' в объеме, соответствующем требованиям профессионального обучения (повышения квалификации) «'.($this->course ? $this->course->title : "_________").'» '.($this->course ? $this->course->length : "___").' часов', 75);
        $this->delimeter();
        $this->tablerow(['A' => '№ п/п', 'B' => 'Ф.И.О.', 'C' => 'Должность', 'D' => 'Организация', 'E' => 'Результат проверки знаний'], true);
        foreach($this->group->users as $i => $user):
            $this->tablerow(['A' => $i+1, 'B' => $user->last_name." ".$user->name." ".$user->patronymic,
                'C' => $user->position, 'D' => $this->group->contractor->name, 'E' => 'Хорошо'], false);
        endforeach;
        $this->delimeter();
        $this->signature(['Председатель', $this->group->chairman]);
        $this->bigDelimeter();
        $this->signature(['Члены комиссии', $this->group->member1]);
        $this->delimeter();
        $this->signature([' ', $this->group->member2]);

        $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);

        // 4 лист
        $this->index++;
        $this->header('Выписка из протокола № '.$this->group->protocol.' / '.$this->group->number.' заседания экзаменационной комиссии ООО «ТУЦ»', 18, true);
        $this->delimeter();
        $this->dateLine();
        $this->index++;
        $this->paragraph('Квалификационная комиссия в составе: ', 25);
        $this->delimeter();
        $this->paragraph('Председатель: '.$this->group->chairman2_pos.' '.$this->group->chairman2, 25);
        $this->delimeter();
        $this->paragraph('Члены комиссии: '.$this->group->member3_pos.' '.$this->group->member3.($this->group->member4 ? ', '.$this->group->member4_pos.' '.$this->group->member4 : ''), 40);
        $this->delimeter();
        $this->paragraph('Секретарь комиссии: '.$this->group->secretary_pos.' '.$this->group->secretary, 25);
        $this->delimeter();
        $this->paragraph('Обсудив результаты обучения, промежуточной и итоговой аттестации обучающихся по программе профессионального обучения (повышения квалификации)  «'.($this->course ? $this->course->title : "_________").'» ('.($this->course ? $this->course->length : "___").' часов), решила:', 75);
        $this->delimeter();
        $this->paragraph('считать окончившими обучение в ООО «ТУЦ» следующих обучающихся и подтвердившими квалификацию и установленные разряды:', 25);
        $this->index++;
        $this->tablerow(['A' => '№ п/п', 'B' => 'Ф.И.О.', 'C' => 'Должность', 'D' => 'Разряд', 'E' => 'Результат проверки знаний'], true);
        foreach($this->group->users as $i => $user):
            $this->tablerow(['A' => $i+1, 'B' => $user->last_name." ".$user->name." ".$user->patronymic,
                'C' => $user->position, 'D' => $this->group->contractor->name, 'E' => 'Хорошо'], false);
        endforeach;
        $this->delimeter();
        $this->signature(['Председатель', $this->group->chairman2]);
        $this->bigDelimeter();
        $this->signature(['Члены комиссии', $this->group->member3]);
        $this->delimeter();
        $this->signature([' ', $this->group->member4]);
        $this->bigDelimeter();
        $this->signature(['Секретарь комиссии', $this->group->secretary]);

    }

    private function createOrders(){
        $this->setHeaderImage();
        $this->sheet->getRowDimension($this->index)->setRowHeight(150);
        $this->index++;
        $this->header('Приказ', 16, true);
        $this->delimeter();
        $this->dateLine();
        $this->delimeter();
        $this->header('О зачислении на обучение', 16, false);
        $this->delimeter();
        $text = 'В связи с завершением комплектования учебной группы '.$this->group->number;
        $text .= ', программа обучения «'.($this->course ? $this->course->title : '____________').'» ';
        $text .= '('.($this->course ? $this->course->length : '___').'ч.),';
        $this->paragraph($text, 60);
        $this->delimeter();
        $this->paragraph('ПРИКАЗЫВАЮ:', 25);
        $this->delimeter();
        $this->paragraph('   1. Зачислить на обучение с '.$this->startDate.' г. по '.$this->endDate.' г.:', 25);
        $this->delimeter();
        $this->tablerow(['A' => '№ п/п', 'B' => 'Ф.И.О', 'C' => 'Должность', 'D' => 'Организация'], true);
        foreach($this->group->users as $i => $user):
            $this->tablerow(['A' => $i+1, 'B' => $user->last_name." ".$user->name." ".$user->patronymic, 'C' => $user->position, 'D' => $this->group->contractor->name], false);
        endforeach;
        $this->delimeter();
        $this->paragraph('   2. Назначить куратором группы и возложить ответственность за организационно-методическое сопровождение программы на '.$this->group->secretary2, 50);
        $this->delimeter();
        $this->paragraph('   3. Контроль за исполнением настоящего приказа оставляю за собой.', 25);
        $this->bigDelimeter();
        $this->signature(['Директор', $this->director]);
        $this->sheet->setBreak('A'.$this->index, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
        $this->sheet->getRowDimension($this->index)->setRowHeight(150);
        $this->index++;
        $this->header('Приказ', 18, true);
        $this->delimeter();
        $this->dateLine();
        $this->delimeter();
        $this->header('Об отчислении обучающихся', 14, false);
        $this->delimeter();
        $text = 'В связи с успешным завершением обучения по программе «'.($this->course ? $this->course->title : '____________').'» ';
        $text .= '('.($this->course ? $this->course->length : '___').'ч.), ';
        $text .= 'обучающихся группы '.$this->group->number;
        $this->paragraph($text, 40);
        $this->delimeter();
        $this->paragraph('ПРИКАЗЫВАЮ:', 25);
        $this->delimeter();
        $this->paragraph('   1. Отчислить с обучения и выдать удостоверения установленного образца:', 25);
        $this->delimeter();
        $this->tablerow(['A' => '№ п/п', 'B' => 'Ф.И.О', 'C' => 'Должность', 'D' => 'Организация'], true);
        foreach($this->group->users as $i => $user):
            $this->tablerow(['A' => $i+1, 'B' => $user->last_name." ".$user->name." ".$user->patronymic, 'C' => $user->position, 'D' => $this->group->contractor->short_name], false);
        endforeach;
        $this->delimeter();
        $this->paragraph('   2. Контроль за исполнением настоящего приказа оставляю за собой.', 25);
        $this->bigDelimeter();
        $this->signature(['Директор', $this->director]);
    }

    private function createStatement(){
        $this->setHeaderImage();
        $this->sheet->getRowDimension($this->index)->setRowHeight(150);
        $this->index++;
        $this->header('Ведомость выдачи удостоверений', 16, true);
        $this->delimeter();
        $this->bold();
        $this->paragraph("Заказчик: ".$this->group->contractor->name, 25);
        $this->delimeter();
        $this->bold();
        $this->paragraph("Программа обучения: ".($this->course ? $this->course->title : "_____________"), 25);
        $this->delimeter();
        $this->bold();
        $this->paragraph($this->startDate." — ".$this->endDate, 50);
        $this->delimeter();
        $this->tablerow(['A' => '№ п/п', 'B' => 'Ф.И.О.', 'C' => 'Подпись', 'D' => '№ удостоверения', 'E' => 'Дата выдачи'], true);
        foreach($this->group->users as $i => $user):
            $this->tablerow(['A' => $i+1, 'B' => $user->last_name." ".$user->name." ".$user->patronymic,
                'C' => '', 'D' => '', 'E' => $this->startDate.' г.'], false);
        endforeach;

    }

    private function setHeaderImage(){
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        $drawing->setName('logo');
        $drawing->setPath(public_path('images/header.jpg'));
        $drawing->setWidth(800);

        $this->sheet->getHeaderFooter()->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_CENTER);
        $this->sheet->getHeaderFooter()->setOddHeader('&C&G');
        $this->sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
    }

    private function dateLine(){
        $this->index++;
        $this->sheet->mergeCells("A$this->index:B$this->index");
        $this->sheet->setCellValue("A$this->index", date('d.m.Y'));
        $this->sheet->setCellValue("C$this->index", 'г. Тюмень');
        $this->sheet->setCellValue($this->lastColumn.$this->index, "№ ТУЦ – ".date('Y')."/У");
        $style = $this->sheet->getStyle("A$this->index:".$this->lastColumn.$this->index);
        $style->getFont()->setSize(16)->setBold(true);
        $style = $this->sheet->getStyle("C$this->index");
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $style = $this->sheet->getStyle($this->lastColumn.$this->index);
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $this->index++;
        return $this;
    }

    private function signature($arr = ['Директор', '___________']){
        $this->sheet->mergeCells("A$this->index:B$this->index");
        $this->sheet->setCellValue("A$this->index", $arr[0]);
        $this->sheet->setCellValue($this->lastColumn.$this->index, $arr[1]);
        $style = $this->sheet->getStyle($this->lastColumn.$this->index);
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $this->index++;
        return $this;
    }

    private function bold(){
        $this->sheet->getStyle("A$this->index:$this->lastColumn".$this->index)->getFont()->setBold(true);
        return $this;
    }

    private function size($size){
        $this->sheet->getStyle("A$this->index:$this->lastColumn".$this->index)->getFont()->setSize($size);
        return $this;
    }

    private function center(){
        $this->sheet->getStyle("A$this->index:$this->lastColumn".$this->index)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        return $this;
    }

    private function header($title, $size, $bold){
        $this->sheet->mergeCells("A$this->index:$this->lastColumn".$this->index);
        $style = $this->sheet->getStyle("A$this->index:$this->lastColumn".$this->index);
        $this->sheet->setCellValue("A$this->index", $title);
        $style->getFont()->setSize($size)->setBold($bold);
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->sheet->getRowDimension($this->index)->setRowHeight(-1);
        $this->index++;
    }

    private function paragraph($text, $height){
        $this->sheet->mergeCells("A$this->index:".$this->lastColumn.$this->index);
        $this->sheet->setCellValue("A$this->index", $text);
        $this->sheet->getRowDimension($this->index)->setRowHeight($height);
        $this->index++;
        return $this;
    }

    private function caption($text){
        $this->sheet->mergeCells("A$this->index:".$this->lastColumn.$this->index);
        $this->sheet->setCellValue("A$this->index", $text);
        $this->sheet->getStyle("A$this->index")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_TOP);
        $this->sheet->getStyle("A$this->index")->getFont()->setSize(8);
        $this->sheet->getRowDimension($this->index)->setRowHeight(15);
        $this->index++;
        return $this;
    }

    private function line(){
        $this->sheet->getStyle("A$this->index:".$this->lastColumn.$this->index)->getBorders()
            ->getTop()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('#000'));
        return $this;
    }

    private function delimeter(){

        $this->sheet->getRowDimension($this->index)->setRowHeight(10);
        $this->index++;
    }

    private function subheader($text){
        $this->sheet->setCellValue("A$this->index", "      $text");
        $this->sheet->getStyle("A$this->index")->getFont()->setBold(true);
        $this->index++;
    }

    private function listItem($text){
        $this->sheet->setCellValue("A$this->index", "     • $text");
        $this->index++;
    }

    private function tablerow($titles, $bold){

        foreach($titles as $col => $title):
            $this->sheet->setCellValue($col.$this->index, $title);
        endforeach;
        $style = $this->sheet->getStyle("A$this->index:".$this->lastColumn.$this->index);
        $style->getFont()->setBold($bold);
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $style->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('#000'));

        $this->index++;
    }

    private function setColumns($columns){
        foreach($columns as $col => $width):
            $this->sheet->getColumnDimension($col)->setWidth($width);
        endforeach;
        $this->columns = array_keys($columns);
        $this->lastColumn = $this->columns[count($this->columns) - 1];

        $this->sheet->getStyle($this->columns[0]."1:".$this->lastColumn."1000")->getAlignment()->setWrapText(true)->setVertical('top');
        $this->sheet->getStyle($this->columns[0]."1:".$this->lastColumn."1000")->getFont()->setName("Times New Roman")->setSize(14);
    }

    private function bigDelimeter(){
        $this->sheet->getRowDimension($this->index)->setRowHeight(30);
        $this->index++;
    }

    public function download(){
        $writer = new Xlsx($this->xlcx);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.($this->title.'.xlsx').'"');
        $writer->save('php://output');
        exit();
    }

}
