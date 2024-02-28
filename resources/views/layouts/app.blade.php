<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head itemscope itemtype="http://schema.org/WPHeader">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <title itemprop="headline">@yield('title') | Тюменский Учебный Центр</title>
        <meta itemprop="description" name="description" content="@yield('description')">
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var preloader = document.getElementById("preloader");
                preloader.style.transition = "opacity 1s";
                preloader.style.opacity = 0;
                setTimeout(function() {
                    preloader.remove();
                }, 1000);
            });
        </script>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
        @if(session('impaired'))
            <link rel="stylesheet" href="{{ asset('css/impaired.css') }}" />
        @endif
        <script src="{{ asset('js/main.js') }}"></script>
        @include('blocks.metric')
        <meta name="google-site-verification" content="iw4ek7QAeS_EK0frUsz6DM4WT_d27-B24ncMOPyxfgk" />
    </head>
    <body>
        <div>
            @include('blocks.preloader')
            @include('navigation.navbar')
            @yield('upper-content')
            <div class="uk-container uk-padding-small">
                @include('blocks.breadcrumbs')
                <div class="uk-padding uk-padding-remove-horizontal">
                    @yield('content')
                </div>
                @include('navigation.mobile')
            </div>
            @include('footer.footer')
            @include('blocks.modal')
            @include('blocks.lead')
        </div>
    </body>
</html>
