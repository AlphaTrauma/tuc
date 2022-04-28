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
                'slug' => 'contacts',
                'deletable' => false
            ],
            [
                'title' => 'Основные сведения',
                'html' => 'Текст по умолчанию',
                'slug' => 'information',
                'deletable' => false
            ],
            [
                'title' => 'Документы',
                'html' => 'Текст по умолчанию',
                'slug' => 'documents',
                'deletable' => false
            ],
            /*[
                'title' => 'Руководство',
                'html' => 'Текст по умолчанию',
                'slug' => 'managers',
                'deletable' => false
            ],
            [
                'title' => 'Преподавательский состав',
                'html' => 'Текст по умолчанию',
                'slug' => 'teachers',
                'deletable' => false
            ],*/
            [
                'title' => 'График работы',
                'html' => 'Текст по умолчанию',
                'slug' => 'schedule',
                'deletable' => false
            ],
            [
                'title' => 'График обучения',
                'html' => 'Текст по умолчанию',
                'slug' => 'timetable',
                'deletable' => false
            ],
            [
                'title' => 'Все направления',
                'html' => 'Текст по умолчанию',
                'slug' => 'all_directions',
                'deletable' => false
            ],

        ];

        foreach($pages as $page):
            Page::create($page);
        endforeach;

    }
}
