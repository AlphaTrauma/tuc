<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'key' => 'shortname',
                'value' => 'ООО «‎ТУЦ»',
                'type' => 'contacts'
            ],
            [
                'key' => 'name',
                'value' => 'Открытое акционерное общество «Тюменский Учебный Центр»',
                'type' => 'contacts'
            ],
            [
                'key' => 'phone',
                'value' => '8 (3452) 564-919',
                'type' => 'contacts'
            ],
            [
                'key' => 'email',
                'value' => 'tuc.tmn@mail.ru',
                'type' => 'contacts'
            ],
            [
                'key' => 'address',
                'value' => 'Российская Федерация, г. Тюмень, ул. Одесская, д. 48-А/2',
                'type' => 'contacts'
            ],
            [
                'key' => 'INN',
                'value' => '7203459280',
                'type' => 'contacts'
            ],
            [
                'key' => 'OGRN',
                'value' => '1187232024154',
                'type' => 'contacts'
            ],
            [
                'key' => 'license',
                'value' => '456783568-45673',
                'type' => 'contacts'
            ],
            [
                'key' => 'post',
                'value' => 'Российская Федерация, г. Тюмень, ул. Одесская, д. 48-А/2',
                'type' => 'contacts'
            ],
            [
                'key' => 'metric',
                'value' => '',
                'type' => 'system'
            ],
            [
                'key' => 'recipient',
                'value' => 'tuc.tmn@mail.ru',
                'type' => 'system'
            ],

        ];
        foreach($settings as $setting):
            Settings::create($setting);
        endforeach;
    }
}
