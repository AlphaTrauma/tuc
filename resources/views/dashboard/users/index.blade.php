@extends('layouts.dashboard')

@section('title')
    Зарегистрированные пользователи сайта
@endsection

@section('content')
    <h2>Список пользователей</h2>
    @foreach($users as $user)
        <div class="uk-card uk-card-default uk-padding-small uk-card-body uk-margin-top uk-width-1-1">
            <div><span class="uk-margin-right"><b>#{{ $user->id }}</b></span><span class="uk-icon" uk-icon="icon: user"></span> {{ $user->name }} <span class="uk-icon" uk-icon="icon: email"></span> <i>{{ $user->email }}</i></div>
            <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                <li><a title="Редактировать данные" href="" uk-icon="icon: file-edit"></a></li>
                <li><a title="Удалить пользователя" href="#" uk-icon="icon: trash"></a></li>
            </ul>
        </div>
    @endforeach
@endsection
