<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =
        [
            [
        'name' => 'Администратор',
        'patronymic' => '',
        'last_name' => '',
        'email' => 'deloriet@gmail.com',
        'phone' => '',
        'position' => 'Разработчик',
        'organization' => 'АО "Институт Нефтегазпроект"',
        'role' => 'admin',
        'password' => Hash::make('loriet21')
            ]
        ];

        foreach($users as $user):
            User::create($user);
        endforeach;
    }
}
