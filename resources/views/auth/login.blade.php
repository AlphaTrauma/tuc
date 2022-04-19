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
                        Войти в систему
                    </legend>
                    <div class="uk-margin">
                        <input class="uk-input" type="text" name="email" required placeholder="E-mail">
                    </div>
                    <div class="uk-margin">
                        <input class="uk-input" type="password" name="password" placeholder="Пароль"
                               required autocomplete="current-password">
                    </div>

                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input name="remember" class="uk-checkbox" type="checkbox" checked> Запомнить меня</label>
                    </div>

                    <div class="uk-margin">
                        <input type="submit" class="uk-button uk-button-primary" value="Войти">
                    </div>

                    <div class="uk-margin">
                        @if (Route::has('password.request'))
                            <a class="uk-button uk-button-link" href="{{ route('password.request') }}">
                                Забыли пароль?
                            </a>
                        @endif
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
@endsection
