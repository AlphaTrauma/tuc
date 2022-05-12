@extends('layouts.app')

@section('title')
    {{ $item->title }}
@endsection

@section('description')
    Тюменский Учебный Центр. {{ $item->title }}
@endsection

@section('content')
    <h1 class="uk-title uk-margin-bottom">{{ $item->title }}</h1>
    <section class="uk-padding uk-padding-remove-horizontal">
        <div class="uk-card-default uk-card-body uk-box-shadow-small @if($item->slug === 'documents') documents @endif">
            {!! $item->html  !!}
        </div>
        @switch($item->slug)
            @case('contacts')
            <div class="uk-padding-small uk-padding-remove-horizontal">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A2b5f5bcc2035971849cb35acbe13d892c68e700b626726918f0176055e578964&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
            </div>
            @break
            @case('all_directions')
                @php
                    $items = App\Models\Direction::query()->get();
                @endphp
                @include('main.directions')
            @break
            @case('documents')
                @include('blocks.gallery')
            @break
        @endswitch
    </section>
@endsection
