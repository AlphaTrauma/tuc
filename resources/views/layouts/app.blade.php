<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>ТУЦ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div class="uk-container">
        @include('header.head')

        @yield('content')
    </div>
    @include('footer.footer')
</body>
</html>
