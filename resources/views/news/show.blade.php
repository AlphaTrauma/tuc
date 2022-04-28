@extends('layouts.app')

@section('title')
    {{ $item->title }}
@endsection

@section('content')
    <h1 class="uk-title uk-margin-bottom">{{ $item->title }}</h1>
    <section class="uk-padding uk-padding-remove-horizontal">
        <div class="uk-card-default uk-card-body">
            {!! $item->html  !!}
        </div>
        <div class="uk-padding uk-padding-remove-horizontal">
            <div class="uk-child-width-1-3@m uk-grid uk-grid-match" uk-grid>
                @foreach($item->courses as $course)
                    @include('courses.course')
                @endforeach
            </div>
        </div>
    </section>
@endsection
