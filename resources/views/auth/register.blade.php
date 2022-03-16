@extends('layouts.app')

@section('title')
    Вход
@endsection

@section('content')
    <div class="uk-flex uk-flex-around">
        <div class="uk-card uk-card-body uk-width-large">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend">
                        Войти в систему
                    </legend>
                    <div class="uk-margin">
                        <input class="uk-input" type="text" name="name" required placeholder="Имя">
                    </div>
                    <div class="uk-margin">
                        <input class="uk-input" type="text" name="email" required placeholder="E-mail">
                    </div>
                    <div class="uk-margin">
                        <input class="uk-input" type="password" name="password" placeholder="Пароль"
                               autocomplete="new-password">
                    </div>
                    <div class="uk-margin">
                        <input class="uk-input" type="password" name="password_confirmation" placeholder="Повторите пароль"
                               required>
                    </div>
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input name="remember" class="uk-checkbox" type="checkbox" checked> Запомнить меня</label>
                    </div>

                    <div class="uk-margin">
                        <input type="submit" class="uk-button uk-button-primary" value="Зарегистрироваться">
                    </div>

                    <div class="uk-margin">
                        @if (Route::has('password.request'))
                            <a class="uk-button uk-button-link" href="{{ route('password.request') }}">
                                Я забыл пароль
                            </a>
                        @endif
                    </div>

                </fieldset>
            </form>
            @if($errors->any())
                <div class="uk-padding-small uk-alert-danger">
                    <ul class="uk-list">
                        @foreach($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection

