@extends('layouts.personal')

@section('content')
    <h1>Личный кабинет студента</h1>

    <h2><a class="uk-link-text" href="{{ route('personal.active') }}">Активные курсы ({{ auth()->user()->active_courses->count() }})</a></h2>
    <h2><a class="uk-link-text" href="{{ route('personal.closed') }}">Завершённые курсы ({{ auth()->user()->completed_courses->count() }})</a></h2>
@endsection
