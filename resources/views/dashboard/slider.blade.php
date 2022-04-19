@extends('layouts.dashboard')

@section('title')
    Управление слайдером
@endsection

@section('content')
    @include('blocks.errors')
    <h2 class="uk-title">Управление слайдером</h2>
    <slider></slider>
    <alerts></alerts>
@endsection
