@extends('layouts.app')

@section('title')
    {{ $item->title }}
@endsection

@section('content')
    <h2>{{ $item->title }}</h2>
    <div class="uk-card uk-card-default uk-card-body">
        {!! $item->html  !!}
        @switch($item->slug)
            @case('contacts')
            <div class="uk-padding-small uk-padding-remove-horizontal">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A2b5f5bcc2035971849cb35acbe13d892c68e700b626726918f0176055e578964&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
            </div>
            @break
        @endswitch
    </div>
@endsection