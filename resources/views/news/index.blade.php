@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <h1 class="uk-title uk-margin-bottom">{{ $title }}</h1>
    <section class="uk-padding uk-padding-remove-horizontal" itemscope itemtype="http://schema.org/Blog">
        @forelse($items as $article)
            <article class="uk-margin-bottom" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">
                <h2><a class="uk-link-reset" href="{{ route('news.item', ['slug' => $article->slug]) }}" itemprop="headline">{{ $article->title }}</a></h2>
                <small><time itemprop="datePublished" datetime="{{ $article->created_at->format('Y-m-d') }}">{{ $article->created_at->format('d.m.Y') }}</time></small>
                <p itemprop="description">{{ $article->text }}</p>
                <div class="uk-position-relative" style="height: 30px;">
                    <div class="uk-display-inline-block uk-position-center-right">
                        <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="{{ route('news.item', ['slug' => $article->slug]) }}"/>
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
