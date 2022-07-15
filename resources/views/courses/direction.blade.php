@extends('layouts.app')

@section('title')
    {{ $item->title }}
@endsection

@section('description')
    {{ $item->title }}, курсы Тюменского Учебного Центра.
@endsection

@section('content')
    <section>
        <div uk-grid class="uk-grid">
            <div class="uk-width-1-3@s uk-flex-last@l">
                <img src="{{ asset($item->image->filepath) }}" alt="">
            </div>
            <div class="uk-width-2-3@s">
                <h1>{{ $item->title }}</h1>
                <div class="uk-margin">
                    {{ $item->description }}
                </div>
                @if($item->html)
                    <div class="uk-margin-small">
                        {!! $item->html !!}
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section>
        <h2>{{ $item->title }}, все курсы:</h2>
        <div class="uk-padding uk-padding-remove-horizontal">
            <div class="uk-child-width-1-4@m uk-grid uk-grid-match" uk-grid itemscope itemtype="http://schema.org/ItemList">
                @foreach($item->courses as $course)
                    @isset($course->image->filepath)
                        @include('courses.course')
                    @endisset
                @endforeach
            </div>
        </div>
    </section>

@endsection
