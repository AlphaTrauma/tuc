@extends('layouts.dashboard')

@section('title')
    Управление курсами и направлениями
@endsection

@section('content')
    <h2 class="uk-title">Управление курсами и направлениями</h2>
    @php
        [

                        [
                            'id' => 1,
                            'title' => 'Пожарная безопасность',
                            'description' => '',
                            'courses' => [
                                [
                                    'title' => 'Действия в чрезвычайной ситуации',
                                    'hours' => 22
                                ],
                                [
                                    'title' => 'Основы пожарной безопасности',
                                    'hours' => 12
                                ],
                                [
                                    'title' => 'Пожарная безопасность при деревообработке',
                                    'hours' => 30
                                ]
                            ]
                        ],
                        [
                            'id' => 2,
                            'title' => 'Безопасность труда',
                            'description' => '',
                            'courses' => [
                                    'title' => 'Основы безопасности труда',
                                    'hours' => 10
                                ],
                                [
                                    'title' => 'Безопасность труда для руководителей',
                                    'hours' => 22
                                ]
                        ]
                    ]
    @endphp
    <div>
        <courses></courses>
    </div>
@endsection
