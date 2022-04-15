@extends('layouts.app')

@section('title')
    {{ $item->title }}
@endsection

@section('content')
    <div class="uk-flex">
        <div class="uk-width-1-2@s">
            <h1>{{ $item->title }}</h1>
            @if($item->html)
                <div class="uk-margin-small">
                    {!! $item->html !!}
                </div>
            @endif
        </div>
        <div class="uk-width-1-2@s uk-padding">
            <img src="{{ asset($item->image->filepath) }}" alt="">
        </div>
    </div>

@endsection
