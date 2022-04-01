<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | Тюменский Учебный Центр</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/uikit.js') }}"></script>
    </head>
    <body>
        <div>
            @include('navigation.navbar')
            <div class="uk-container uk-padding-small">
                @yield('content')
                @include('navigation.mobile')
            </div>
            @include('footer.footer')
        </div>
    </body>
</html>
