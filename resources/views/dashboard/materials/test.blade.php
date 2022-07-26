@extends('layouts.dashboard')

@section('title')
    Тестовая
@endsection

@section('content')
    <h1>Конструктор теста</h1>
    <a href="{{ route('courses.show', $course->id) }}" class="uk-button uk-button-primary uk-margin-bottom"><span uk-icon="arrow-left" class="uk-margin-small-right"></span>Вернуться в конструктор курса</a>
    <div class="uk-padding uk-padding-remove-vertical">
        <test-container></test-container>
    </div>
@endsection
