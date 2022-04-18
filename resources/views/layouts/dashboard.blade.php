<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>
        @yield('title') | Панель управления сайтом ТУЦ
    </title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>
<body>
<div class="uk-container-expand" id="app">
    <div uk-grid>
        @include('dashboard.navigation')
        <div class="uk-width-expand">
            <div class="uk-card uk-card-body">
                @yield('content')
            </div>
        </div>
        <div class="uk-width-medium">
        </div>
    </div>
</div>
@include('blocks.modal')
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
