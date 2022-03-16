<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Панель управления ТУЦ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<div class="uk-container-expand">
    <div uk-grid>
        @include('dashboard.navigation')
        @yield('content')
    </div>
</div>
</body>
</html>
