@extends('layouts.dashboard')

@section('content')
    <div class="uk-padding">
        @foreach($items as $item)
            <div class="uk-card-default uk-card-small uk-grid uk-grid-match " uk-grid>
                <div class="uk-height-small uk-width-1-6 uk-background-contain" style="background-image: url({{ asset($item->filepath) }})">
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
            {{ $items->links('blocks.pagination') }}
    </div>
@endsection
