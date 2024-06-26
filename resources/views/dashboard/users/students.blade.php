@extends('layouts.dashboard')

@section('title')
    Список студентов
@endsection

@section('content')
    <h2>Список студентов</h2>
    @include('blocks.errors')
    @include('dashboard.users.actions')
    @forelse($users as $user)
        <div class="uk-card uk-card-default uk-padding-small uk-card-body uk-margin-top uk-width-1-1">
            <div><span class="uk-margin-right"><b>#{{ $user->id }}</b></span><span class="uk-icon" uk-icon="icon: user"></span>
                {{ $user->name }} {{ $user->patronymic }} {{ $user->last_name }}
                <span class="uk-icon" uk-icon="icon: email"></span> <i>{{ $user->email }}</i>
            </div>
            <button class="uk-button uk-button-small uk-margin-small" type="button" uk-toggle="target: #courses-{{ $user->id }}; animation: uk-animation-fade">
                Список курсов <span uk-icon="chevron-down"></span>
            </button>
            <div hidden id="courses-{{ $user->id }}">
                <ul class="uk-list-divider uk-list">
                    @forelse($user->user_courses as $user_course)
                        @if($user_course->status)
                            <li class="uk-text-success uk-position-relative"><b>{{ $user_course->course->title }}</b> <span uk-icon="icon: check; ratio: 1.2"></span>
                                <br><a href="{{ route("user.results", $user_course) }}" class="uk-link uk-text-secondary" uk-tooltip="Результаты последнего прохождения тестов">Ответы <span uk-icon="file-text"></span></a>
                                <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                                    <delete-button action="/dashboard/courses/{{ $user_course->id }}/deleteFromUser" text="Удалить курс"></delete-button>
                                </ul>
                            </li>
                        @elseif($user_course->first_material and $user_course->first_material->status)
                            <li class="uk-text-warning uk-position-relative"><b>{{ $user_course->course->title }}</b>
                                <br><a href="{{ route("user.results", $user_course) }}" class="uk-link uk-text-secondary" uk-tooltip="Результаты последнего прохождения тестов">Ответы <span uk-icon="file-text"></span></a>
                                <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                                    <delete-button action="/dashboard/courses/{{ $user_course->id }}/deleteFromUser" text="Удалить курс"></delete-button>
                                </ul>
                            </li>
                        @else
                            <li class="uk-position-relative">{{ $user_course->course->title }}
                                <br><a href="{{ route("user.results", $user_course) }}" class="uk-link uk-text-secondary" uk-tooltip="Результаты последнего прохождения тестов">Ответы <span uk-icon="file-text"></span></a>
                                <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                                    <delete-button action="/dashboard/courses/{{ $user_course->id }}/deleteFromUser" text="Удалить курс"></delete-button>
                                </ul>
                            </li>
                        @endif
                    @empty
                        У пользователя нет курсов.
                    @endforelse
                </ul>
            </div>

            <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                <li><a uk-tooltip="Добавить курс" href="#add-course-{{ $user->id }}" uk-toggle uk-icon="icon: plus"></a></li>
                <li><a uk-tooltip="Открыть профиль" href="{{ route('user.show', $user->id) }}" uk-icon="icon: user"></a></li>
                <li><a uk-tooltip="Редактировать данные" href="{{ route('user.edit', $user->id) }}" uk-icon="icon: file-edit"></a></li>
                <!--<li><a uk-tooltip="Удалить пользователя" href="#" uk-icon="icon: trash"></a></li>-->
            </ul>
        </div>
        <div id="add-course-{{ $user->id }}" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                <h2 class="uk-modal-title">Открыть доступ к курсу</h2>
                <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('courses.add') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
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
    @empty
        <p>Результатов не найдено</p>
    @endforelse
    {{ $users->links('blocks.pagination') }}
@endsection
