@extends('layouts.dashboard')

@section('title')
    Управление новостями и акциями
@endsection

@section('content')
    <h2 class="uk-title">Управление новостями и акциями</h2>
    @include('blocks.errors')
    <a href="{{ route('news.create') }}" class="uk-button uk-button-primary">Создать</a>
    <div>
        @forelse($items as $item)
            <div class="uk-card uk-card-default uk-padding-small uk-card-body uk-margin-top uk-width-1-1">
                <div>{{ $item->title }} | <small><i>{{ $item->slug }}</i></small></div>
                <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                    @if($item->slug)
                        <li><a title="Открыть страницу" href="{{ route('news.show', $item->slug) }}" uk-icon="icon: link"></a></li>
                    @endif
                    <li><a title="Редактировать" href="{{ route('news.edit', $item->id)}}" uk-icon="icon: file-edit"></a></li>
                    <li><a title="Удалить" href="{{ route('news.delete', $item->id) }}" uk-icon="icon: trash"></a></li>
                </ul>
            </div>
        @empty
            <p class="uk-padding uk-padding-remove-horizontal">Новостей и акций нет.</p>
        @endforelse
            {{ $items->links('blocks.pagination') }}
    </div>
@endsection
