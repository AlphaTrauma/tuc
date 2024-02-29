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
            Список колонок: <b>A</b> — фамилия, <b>B</b> — имя, <b>A</b> — отчество, <b>D</b> — должность, <b>E</b> — дата рождения (тип данных ячейки "строка", а не "дата"), <b>F</b> — СНИЛС, <b>G</b> — паспорт, <b>H</b> — моб. телефон, <b>I</b> — документ об образовании.
        </div>
    </div>

    @foreach($item->groups as $group)
        <div class="uk-card uk-card-default uk-padding uk-margin-top">
            <div class="uk-card-header " >
                <div class="uk-flex uk-flex-between">
                    <h2 class="uk-card-title">Группа от {{ $group->created_at->format('d.m.Y') }}
                    </h2>
                    <div><a href="#add-course-{{ $group->id }}" uk-toggle class="uk-button uk-button-default">Добавить курс</a></div>
                    <form method="POST" action="{{ route('group.update', $group) }}" class="uk-grid-small" uk-grid>
                        @csrf
                        <div class="uk-width-1-3">
                            <input class="uk-input" id="form-horizontal-text" name="start_date" value="{{ $group->start_date ? $group->start_date->format('Y-m-d') : '' }}" type="date">
                        </div>
                        <div class="uk-width-1-3">
                            <input class="uk-input" id="form-horizontal-text" name="end_date" value="{{ $group->end_date ? $group->end_date->format('Y-m-d') : '' }}" type="date">
                        </div>
                        <div class="uk-width-1-3">
                            @if($group->end_date)
                                <input class="uk-button" value="Изменить даты" type="submit">
                            @else
                                <input class="uk-button uk-button-danger" value="Задать даты" type="submit">
                            @endif

                        </div>
                    </form>
                </div>
                @if($group->users->count() and $group->users->first()->latestCourse)
                    <small class="uk-text-success">({{ $group->users->first()->latestCourse->course->title }})</small>
                @else
                    <small  class="uk-text-danger">(Курс не выбран)</small>
                @endif

            </div>
            <div class="uk-card-body">
                <div class="uk-width-medium uk-float-right">
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'orders']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать приказы <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'statement']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать ведомость <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'protocol']) }}" class="uk-button uk-button-text uk-button-small  uk-margin-small">Скачать протоколы <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificates']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать удостоверения <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificatesPC']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать удостоверения ПК <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificatesPrint']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать удостоверения печать <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificatesWorker']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать свид. проф. раб. <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificatesWorker2']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать удост. проф. раб. <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'agreements']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать соглашения <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'po']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать реестр ПО <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'dpo']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать реестр ДПО <span uk-icon="download"></span></a>

                </div>

                <ul class="uk-list">
                    @foreach($group->users as $user)
                        <li>
                            <a href="{{ route('user.show', $user->id) }}" class="uk-link uk-link-text">{{ $user->last_name }} @if($user->name){{ mb_substr($user->name, 0, 1) }}.@endif @if($user->patronymic){{ mb_substr($user->patronymic, 0, 1) }}.@endif</a>
                        </li>
                    @endforeach
                </ul>
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
                                    <option value="{{ $id }}">{{ $name }}</option>
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
