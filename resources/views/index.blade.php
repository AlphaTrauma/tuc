@extends('layouts.app')

@section('title')
    Главная
@endsection

@section('content')
    @include('main.news')
    @include('main.courses')
@endsection
