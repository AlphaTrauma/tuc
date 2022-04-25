@extends('layouts.dashboard')

@section('title')
    Редактирование профиля {{ $item->name }} {{ $item->patronymic }} {{ $item->last_name }}
@endsection

@section('content')
    <h1>Редактирование пользователя {{ $item->name }} {{ $item->patronymic }} {{ $item->last_name }}</h1>
    @include('blocks.errors')

            <form action="{{ route('user.update', $item->id) }}" enctype="multipart/form-data" method="POST" class="uk-form-horizontal">
                @csrf
                <div class="uk-flex" uk-flex>
                    <div class="uk-width-2-3">
                        @if(Auth::id() === $item->id)
                            <div class="uk-margin-small">
                                <b>Роль: </b>
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
                        @else
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="role"><b>Роль</b></label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" name="role" id="role">
                                        <option {{ $item->role === 'student' ? 'selected' : '' }} value="student">Студент</option>
                                        <option {{ $item->role === 'teacher' ? 'selected' : '' }} value="teacher">Преподаватель</option>
                                        <option {{ $item->role === 'admin' ? 'selected' : '' }} value="admin">Администратор</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        <hr>
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="email">Электронная почта</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" required name="email" id="email" type="text" value="{{ $item->email }}">
                            </div>
                        </div>
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="name">Имя</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" required name="name" id="name" type="text" value="{{ $item->name }}">
                            </div>
                        </div>
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="last_name">Фамилия</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="last_name" id="last_name" type="text" value="{{ $item->last_name }}">
                            </div>
                        </div>
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="patronymic">Отчество</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="patronymic" id="patronymic" type="text" value="{{ $item->patronymic }}">
                            </div>
                        </div>
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="organization">Организация</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="organization" id="organization" type="text" value="{{ $item->organization }}">
                            </div>
                        </div>
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="position">Должность</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="position" id="position" type="text" value="{{ $item->position }}">
                            </div>
                        </div>

                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="phone">Номер телефона</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="phone" id="phone" type="text" value="{{ $item->phone }}">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3@s">
                        <h3 class="uk-text-center">Фото</h3>
                        <upload image="{{ isset($item->image->filepath) ? asset($item->image->filepath) : '' }}"></upload>
                    </div>
                </div>
                <div class="uk-margin">
                    <input type="submit" value="Сохранить" class="uk-button uk-button-success uk-width-1-1">
                </div>
            </form>
    </div>
@endsection
