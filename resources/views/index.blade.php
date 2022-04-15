@extends('layouts.app')

@section('title')
    Главная
@endsection

@section('content')
    @include('main.slider')
    @include('main.directions')
@endsection
