@extends('layouts.dashboard')

@section('title')
    Данные пользователя {{ $item->name }} {{ $item->patronymic }} {{ $item->last_name }}
@endsection

@section('content')
    <h2>Данные пользователя {{ $item->name }} {{ $item->patronymic }} {{ $item->last_name }}
        <a title="Редактировать профиль" href="{{ route('user.edit', $item->id) }}" class="uk-link-reset"><span uk-icon="icon: file-edit"></span></a></h2>
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
        <div uk-grid class="uk-grid-small uk-width-2-3@s">
            <div style="max-width: 200px" class="uk-padding-small">
                <p class="uk-text-bold">Имя</p>
                <p class="uk-text-bold">Отчество</p>
                <p class="uk-text-bold">Фамилия</p>
                <p class="uk-text-bold">Дата регистрации</p>
                <p class="uk-text-bold">Организация</p>
                <p class="uk-text-bold">Должность</p>
                <p class="uk-text-bold">Электронная почта</p>
                <p class="uk-text-bold">Телефон</p>
                <p class="uk-text-bold">Паспорт</p>
                <p class="uk-text-bold">СНИЛС</p>
                <p class="uk-text-bold">Дата рождения</p>
            </div>
            <div class="uk-padding-small">
                <p>{{ $item->name ? $item->name : '-' }}</p>
                <p>{{ $item->patronymic ? $item->patronymic : '-' }}</p>
                <p>{{ $item->last_name ? $item->last_name : '-' }}</p>
                <p>{{ $item->created_at->format('d.m.Y') }}</p>
                <p>{{ $item->organization ? $item->organization : '-' }}</p>
                <p>{{ $item->position ? $item->position : '-' }}</p>
                <p>{{ $item->email ? $item->email : '-' }}</p>
                <p>{{ $item->phone ? $item->phone : '-' }}</p>
                <p>{{ $item->document ? $item->document : '-' }}</p>
                <p>{{ $item->snils ? $item->snils : '-' }}</p>
                <p>{{ $item->birth_date ? $item->birth_date->format('d.m.Y') : '-' }}</p>
            </div>
        </div>
        <div class=" uk-width-1-3@s">
            <div class="uk-background-center-center uk-background-cover"
                 style="background-image: url({{ isset($item->image->filepath) ? asset($item->image->filepath) : '' }});
                     width: 300px;
                     height: 400px;
                     ">

            </div>
        </div>
    </div>
@endsection
