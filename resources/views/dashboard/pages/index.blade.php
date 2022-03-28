@extends('layouts.dashboard')

@section('title')
    Управление страницами
@endsection

@section('content')
        <h2 class="uk-title">Управление страницами</h2>
        <a href="{{ route('pages.create') }}" class="uk-button uk-button-primary">+</a>
        <div>
            @foreach($pages as $page)
                <div class="uk-card uk-card-default uk-padding-small uk-card-body uk-margin-top uk-width-1-1">
                    <div>{{ $page->title }} | <small><i>{{ $page->slug }}</i></small></div>
                    <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                        <li><a title="Открыть страницу" href="{{ route('page', $page->slug) }}" uk-icon="icon: link"></a></li>
                        <li><a title="Редактировать страницу" href="{{ route('pages.edit', $page->slug)}}" uk-icon="icon: file-edit"></a></li>
                        <li><a title="Удалить страницу" href="#" uk-icon="icon: trash"></a></li>
                    </ul>
                </div>
            @endforeach
        </div>
@endsection
