@extends('layouts.app')

@section('title')
    Главная
@endsection

@section('description')
    Тюменский Учебный Центр. Курсы повышения квалификации, профориентация, дополнительное образование.
@endsection

@section('upper-content')
@endsection

@section('content')
    @if(!session('impaired'))
        @include('main.slider')
    @endif
    @include('main.directions')
    @include('main.benefits')
@endsection
