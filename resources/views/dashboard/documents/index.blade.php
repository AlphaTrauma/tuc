@extends('layouts.dashboard')

@section('title')
    Документы и прочие файлы
@endsection

@section('content')
    <h1>Документы и прочие файлы</h1>
    @include('blocks.errors')

    <div>
        @foreach($items as $item)
            <div class="uk-card uk-card-default uk-padding-small uk-card-body uk-margin-top uk-width-1-1">
                <div>{{ $item->filename }}</div>
                <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                    <li><a title="Скачать файл" href="{{ asset($item->filepath) }}" uk-icon="icon: link"></a></li>
                    <li><a title="Удалить файл" href="{{ route('file.destroy', $item->id) }}" uk-icon="icon: trash"></a></li>
                </ul>
            </div>
        @endforeach
    </div>
@endsection
