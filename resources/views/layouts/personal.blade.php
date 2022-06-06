<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>
        @yield('title') | Личный кабинет студента ТУЦ
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>
<body>
<div class="uk-container-expand" id="app">
    @include('blocks.preloader')
    @include('personal.navigation.navbar')
    <div class="uk-container uk-padding uk-padding-remove-horizontal">

        @yield('content')
        <alerts></alerts>
    </div>

</div>
@include('blocks.modal')
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
