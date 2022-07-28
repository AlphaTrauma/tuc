@extends('layouts.app')

@section('title')
    Вход
@endsection

@section('content')
    @include('blocks.errors')
    <div class="uk-flex uk-flex-around">
        <div class="uk-card uk-card-body uk-width-large">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend">
                        Войти в систему <a class="uk-link-text uk-text-danger" href="#soglasie">*</a>
                    </legend>
                    <div class="uk-margin">
                        <input class="uk-input" type="text" name="email" required placeholder="E-mail">
                    </div>
                    <div class="uk-margin">
                        <input class="uk-input" type="text" name="password" placeholder="Пароль"
                               required autocomplete="current-password">
                    </div>

                    <div class="uk-margin uk-flex uk-flex-between uk-flex-middle">
                        <input type="submit" class="uk-button uk-button-primary" value="Войти">
                        <label><input name="remember" class="uk-checkbox" type="checkbox" checked> Запомнить меня</label>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="uk-margin">
        <p id="soglasie"><span class="uk-text-danger">*</span> Входя на сайт Тюменского Учебного Центра с использованием логина и пароля, вы подтверждаете, что ознакомились с <a class="uk-link" target="_blank" href="{{ asset('uploads/documents/Согласие на обработку.pdf') }}">согласием на обработку</a> и <a class="uk-link" target="_blank" href="{{ asset('uploads/documents/Согласие на распространение.pdf') }}">согласием на распространение</a> ваших персональных данных и принимаете указанные там условия.</p>
    </div>
@endsection
