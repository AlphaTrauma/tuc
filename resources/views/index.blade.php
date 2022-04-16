@extends('layouts.app')

@section('title')
    Главная
@endsection

@section('upper-content')

@endsection

@section('content')
    @include('main.slider')
    @include('main.directions')
    @include('main.benefits')
@endsection
