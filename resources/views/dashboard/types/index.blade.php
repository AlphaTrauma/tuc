@extends('layouts.dashboard')

@section('title')
    Список форм обучения
@endsection

@section('content')
    <h2>Формы обучения:</h2>
    @include('blocks.errors')
    <div class="uk-padding-small">
        <a href="{{ route('types.create') }}" class="uk-button uk-button-primary"><span class="uk-margin-small-right" uk-icon="plus"></span>Создать</a>
    </div>
    <div class="uk-padding-small">
        @forelse($items as $item)
            <div class="uk-margin-bottom">
                <div class="uk-card uk-card-small uk-card-primary uk-margin-bottom">
                    <div class="uk-card-body uk-flex uk-position-relative">
                        <div class="uk-card-title uk-text-center">{{ $item->id }} {{ $item->title }}</div>
                        <ul class="uk-iconnav uk-position-absolute uk-position-center-right uk-padding-small">
                            <li><a href="" uk-tooltip="Открыть список курсов" uk-icon="icon: list"></a></li>
                            <li><a uk-tooltip="Редактировать тип" href="{{ route('types.edit', ['type' => $item]) }}" uk-icon="icon: file-edit"></a></li>
                            <li>
                                <a uk-tooltip="Удалить тип"  href="{{ route('types.delete', ['id' => $item->id]) }}"
                                   uk-icon="icon: trash">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <p>Направления обучения не найдены</p>
        @endforelse
            {{ $items->links('blocks.pagination') }}
    </div>
@endsection
