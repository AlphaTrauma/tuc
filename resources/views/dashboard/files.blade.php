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
                        <p>{{ $item->entity->alias['title'] }}: <b>{{ $item->entity->title }}</b></p>
                    @endisset
                    <p>{{ $item->filename }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
