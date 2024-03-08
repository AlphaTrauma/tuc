@extends('layouts.dashboard')

@section('content')
    <h1>Страница контрагента {{ $item->name }}</h1>
    @include('blocks.errors')
    <upload-contractors :id="{{ $item->id }}">
        @csrf
    </upload-contractors>
    <div class="uk-card uk-card-default uk-margin-top">
        <div class="uk-card-body">
            <b>Памятка по таблице импорта</b>: документ excel с указанными далее столбцами. Список импортируемых пользователей должен начинаться со второй строки (в первой опционально заголовки), в нём не должно быть пустых строк.
            Список колонок: <b>A</b> — фамилия, <b>B</b> — имя, <b>A</b> — отчество, <b>D</b> — должность, <b>E</b> — дата рождения (тип данных ячейки "текстовый", не "дата"), <b>F</b> — СНИЛС, <b>G</b> — паспорт, <b>H</b> — моб. телефон, <b>I</b> — документ об образовании.
        </div>
    </div>

    @foreach($item->groups as $group)
        <div class="uk-card uk-card-default uk-margin-top">
            <div class="uk-card-header" >
                <div>
                    <h2 class="uk-card-title">
                        @if($group->number)
                            Группа {{ $group->number }}
                        @else
                            Группа от {{ $group->created_at->format('d.m.Y') }}
                        @endif

                    </h2>
                    <div class="uk-button-group uk-float-right">
                        <div class="uk-button uk-button-success" type="button" uk-toggle="target: #form-{{ $group->id }}; animation: uk-animation-fade">
                            Настройки группы
                        </div>
                        <a href="#add-course-{{ $group->id }}" uk-toggle class="uk-button uk-button-default">Добавить курс</a>
                    </div>
                </div>
                @if($group->users->count() and $group->users->first()->latestCourse)
                    <small class="uk-text-success">({{ $group->users->first()->latestCourse->course->title }})</small>
                @else
                    <small class="uk-text-danger">(Курс не выбран)</small>
                @endif

            </div>
            <div hidden id="form-{{ $group->id }}" class="uk-card-body">
                @include('dashboard.contractors.form')
            </div>
            <div class="uk-card-body">
               @include('dashboard.contractors.documents')


                @php
                    $chunks = $group->users->chunk(10);
                @endphp
                <ul class="uk-list">
                    @foreach($chunks[0] as $user)
                        <li>
                            <a href="{{ route('user.show', $user->id) }}" class="uk-link uk-link-text">{{ $user->last_name }} @if($user->name){{ mb_substr($user->name, 0, 1) }}.@endif @if($user->patronymic){{ mb_substr($user->patronymic, 0, 1) }}.@endif</a>
                        </li>
                    @endforeach
                </ul>
                @if(count($chunks) > 1)

                    <ul hidden id="users-{{ $group->id }}" class="uk-list">
                        @foreach($chunks as $key => $chunk)
                            @if($key > 0)
                                @foreach($chunk as $user)
                                    <li>
                                        <a href="{{ route('user.show', $user->id) }}" class="uk-link uk-link-text">{{ $user->last_name }} @if($user->name){{ mb_substr($user->name, 0, 1) }}.@endif @if($user->patronymic){{ mb_substr($user->patronymic, 0, 1) }}.@endif</a>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                    <button class="uk-button uk-button-small uk-button-text uk-margin-small" type="button" uk-toggle="target: #users-{{ $group->id }}; animation: uk-animation-fade">
                        Показать/скрыть полный список
                    </button>
                @endif

            </div>
            <div class="uk-card-body">
                <upload-contractors :group="{{ $group->id }}" :id="{{ $item->id }}">
                    @csrf
                </upload-contractors>
            </div>
            <div id="add-course-{{ $group->id }}" class="uk-flex-top" uk-modal>
                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                    <h2 class="uk-modal-title">Открыть доступ к курсу</h2>
                    <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('courses.addGroup') }}">
                        @csrf
                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                        <div class="uk-margin">
                            <select class="uk-select" name="course_id" id="course_id">
                                <option value="">Выберите курс</option>
                                @foreach($courses as $id => $name)
                                    <option value="{{ $id }}">{{ \Illuminate\Support\Str::limit($name, 60) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" class="uk-button uk-button-success uk-width-1-1" value="Открыть доступ">
                    </form>
                </div>
            </div>

        </div>
    @endforeach

@endsection
