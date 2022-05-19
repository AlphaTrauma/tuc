@extends('layouts.app')

@section('title')
    {{ $item->title }}
@endsection

@section('content')
    <div itemscope itemtype="http://schema.org/Article">
        <h1 class="uk-title uk-margin-bottom" itemprop="headline">{{ $item->title }}</h1>
        <section class="uk-padding uk-padding-remove-horizontal">
            <article class="uk-card-default uk-card-body">
                <div itemprop="articleBody">
                    {!! $item->html  !!}
                </div>
                <div class="uk-float-right"><small>Опубликовано <time itemprop="datePublished" datetime="{{ $item->created_at->format('Y-m-d') }}">{{ $item->created_at->format('d.m.Y') }}</time></small></div>
            </article>
            <div class="uk-padding uk-padding-remove-horizontal">
                <div class="uk-child-width-1-3@m uk-grid uk-grid-match" uk-grid itemscope itemtype="http://schema.org/ItemList">
                    @foreach($item->courses as $course)
                        @include('courses.course')
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
