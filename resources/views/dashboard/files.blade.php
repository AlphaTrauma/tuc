@extends('layouts.dashboard')

@section('content')
    <div class="uk-padding">
        @foreach($items as $item)
            <div class="uk-card-default uk-card-small uk-grid uk-grid-match " uk-grid>
                <div class="uk-height-small">
                    <img src="{{ asset($item->filepath) }}" uk-img class="uk-object-contain uk-height-1-1" alt="">
                </div>
                <div class="uk-card-body">
                    @isset($item->entity->alias)
                        <div>{{ $item->entity->alias['title'] }}: <b>{{ $item->entity->title }}</b></div>
                    @endisset
                    <div>{{ $item->filename }}</div>
                    <div><b>{{ $item->readableSize() }}</b></div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
