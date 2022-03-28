<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title' => 'Контакты',
                'html' => 'Текст по умолчанию',
                'slug' => 'contacts'
            ],
            [
                'title' => 'Основные сведения',
                'html' => 'Текст по умолчанию',
                'slug' => 'information'
            ],
            [
                'title' => 'Структура и органы управления образовательной деятельностью',
                'html' => 'Текст по умолчанию',
                'slug' => 'structure'
            ],
            [
                'title' => 'Документы',
                'html' => 'Текст по умолчанию',
                'slug' => 'documents'
            ],
            [
                'title' => 'Руководство',
                'html' => 'Текст по умолчанию',
                'slug' => 'managers'
            ],
            [
                'title' => 'Преподавательский состав',
                'html' => 'Текст по умолчанию',
                'slug' => 'teachers'
            ],
            [
                'title' => 'Финансово-хозяйственная деятельность',
                'html' => 'Текст по умолчанию',
                'slug' => 'activity'
            ],
            [
                'title' => 'График работы',
                'html' => 'Текст по умолчанию',
                'slug' => 'schedule'
            ],
            [
                'title' => 'График обучения',
                'html' => 'Текст по умолчанию',
                'slug' => 'timetable'
            ],

        ];

        foreach($pages as $page):
            Page::create($page);
        endforeach;

    }
}
