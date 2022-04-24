@extends('layouts.dashboard')

@section('title')
    Данные пользователя {{ $item->name }} {{ $item->patronymic }} {{ $item->last_name }}
@endsection

@section('content')
    <h1>Данные пользователя {{ $item->name }} {{ $item->patronymic }} {{ $item->last_name }}</h1>
    @include('blocks.errors')
    <div class="uk-text-bold uk-text-large">Роль:
    @switch($item->role)
        @case('admin')
        Администратор
        @break
        @case('teacher')
        Преподаватель
        @break
        @default
        Студент
    @endswitch
    </div>
    <hr>
    <div uk-grid>
        <div uk-grid class="uk-grid-small">
            <div style="max-width: 200px" class="uk-padding-small">
                <p class="uk-text-bold">Имя</p>
                <p class="uk-text-bold">Отчество</p>
                <p class="uk-text-bold">Фамилия</p>
                <p class="uk-text-bold">Организация</p>
                <p class="uk-text-bold">Должность</p>
                <p class="uk-text-bold">Электронная почта</p>
                <p class="uk-text-bold">Телефон</p>
            </div>
            <div class="uk-padding-small">
                <p>{{ $item->name ? $item->name : '-' }}</p>
                <p>{{ $item->patronymic ? $item->patronymic : '-' }}</p>
                <p>{{ $item->last_name ? $item->last_name : '-' }}</p>
                <p>{{ $item->organization ? $item->organization : '-' }}</p>
                <p>{{ $item->position ? $item->position : '-' }}</p>
                <p>{{ $item->email ? $item->email : '-' }}</p>
                <p>{{ $item->phone ? $item->phone : '-' }}</p>
            </div>
        </div>
        <div>
            <!-- Фото -->
        </div>
    </div>
@endsection
