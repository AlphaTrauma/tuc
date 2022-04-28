@extends('layouts.dashboard')

@section('title')
    Управление страницами
@endsection

@section('content')
        <h2 class="uk-title">Управление страницами</h2>
        @include('blocks.errors')
        <a href="{{ route('pages.create') }}" class="uk-button uk-button-primary">Создать новую страницу</a>
        <div>
            @foreach($pages as $page)
                <div class="uk-card uk-card-default uk-padding-small uk-card-body uk-margin-top uk-width-1-1">
                    <div>{{ $page->title }} | <small><i>{{ $page->slug }}</i></small></div>
                    <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                        @if($page->slug)
                            <li><a title="Открыть страницу" href="{{ route('page', $page->slug) }}" uk-icon="icon: link"></a></li>
                        @endif
                        <li><a title="Редактировать страницу" href="{{ route('pages.edit', $page->id)}}" uk-icon="icon: file-edit"></a></li>
                        @if($page->deletable)
                            <li><a title="Удалить страницу" href="{{ route('pages.delete', $page->id) }}" uk-icon="icon: trash"></a></li>
                        @endif
                    </ul>
                </div>
            @endforeach
        </div>
    {{ $pages->links('blocks.pagination') }}
@endsection
