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
            <ul class="uk-list-striped uk-list">
                @forelse($user->user_courses as $user_course)
                    @if($user_course->status)
                        <ul class="uk-text-success"><b>{{ $user_course->course->title }}</b> <span uk-icon="icon: check; ratio: 1.2"></span></ul>
                    @else
                        <ul>{{ $user_course->course->title }}</ul>
                    @endif
                @empty
                    У пользователя нет курсов.
                @endforelse
            </ul>
            <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                <li><a title="Добавить курс" href="#add-course-{{ $user->id }}" uk-toggle uk-icon="icon: plus"></a></li>
                <li><a title="Открыть профиль" href="{{ route('user.show', $user->id) }}" uk-icon="icon: user"></a></li>
                <li><a title="Редактировать данные" href="{{ route('user.edit', $user->id) }}" uk-icon="icon: file-edit"></a></li>
                <li><a title="Удалить пользователя" href="#" uk-icon="icon: trash"></a></li>
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
