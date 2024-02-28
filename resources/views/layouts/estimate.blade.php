
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head itemscope itemtype="http://schema.org/WPHeader">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title itemprop="headline">@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="{{ asset('js/main.js') }}"></script>
    <meta name="google-site-verification" content="iw4ek7QAeS_EK0frUsz6DM4WT_d27-B24ncMOPyxfgk" />
</head>
<body>
<div class="container" id="app">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://kit.fontawesome.com/e96bfdb519.js" crossorigin="anonymous"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
