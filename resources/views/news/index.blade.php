@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <h1 class="uk-title uk-margin-bottom">{{ $title }}</h1>
    <section class="uk-padding uk-padding-remove-horizontal">
        @forelse($items as $article)
            <article class="uk-margin-bottom">
                <h2><a class="uk-link-reset" href="{{ route('news.item', ['slug' => $article->slug]) }}">{{ $article->title }}</a></h2>
                <small>{{ $article->created_at->format('d.m.Y') }}</small>
                <p>{{ $article->text }}</p>
                <div class="uk-position-relative" style="height: 30px;">
                    <div class="uk-display-inline-block uk-position-center-right">
                        <a href="{{ route('news.item', ['slug' => $article->slug]) }}" class="uk-button uk-button-default ">Открыть</a>
                    </div>

                </div>
            </article>
            @if(!$loop->last)
                <hr>
            @endif
        @empty
        <p>Новостей и акций нет.</p>
        @endforelse
    </section>
@endsection
