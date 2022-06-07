@extends('layouts.app')

@section('title')
Восстановление пароля
@endsection

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
    @csrf

    <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <div class="uk-margin">
                <input class="uk-input" type="email" name="email" required value="{{ old('email', $request->email) }}" autofocus placeholder="E-mail">
            </div>
        </div>

        <!-- Password -->
        <div class="uk-margin">
            <input class="uk-input" type="text" name="password" placeholder="Пароль"
                   required>
        </div>

        <!-- Confirm Password -->
        <div class="uk-margin">
            <x-label for="password_confirmation" :value="__('Confirm Password')" />

            <input id="password_confirmation" class="uk-input"
                     type="password"
                     name="password_confirmation" required />
        </div>

        <div class="uk-margin">
        <input type="submit" class="uk-button uk-button-primary" value="Сменить пароль">
        </div>
    </form>

@endsection
