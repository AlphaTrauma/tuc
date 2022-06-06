@extends('layouts.dashboard')

@section('title')
    Структура курса {{ $item->title }}
@endsection

@section('content')
    <h2 class="uk-title">Конструктор курса</h2>
    @include('blocks.errors')
    <section class="uk-padding uk-padding-remove-horizontal">
        <h3>{{ $item->title }}</h3>
        <p>{{ $item->description }}</p>
        <div>
            @foreach($item->blocks as $block)
                <div class="uk-card-small uk-card-default uk-card-body uk-margin-bottom">
                    <div class=" uk-position-relative uk-margin-bottom">
                        <span>{{ $block->ordering }}. {{ $block->title }}</span>
                        <ul class="uk-iconnav uk-position-absolute uk-position-center-right uk-padding-small">
                            <li><a uk-tooltip="Редактировать блок" href="{{ route('blocks.edit', $item->id) }}" uk-icon="icon: file-edit"></a></li>
                            <li>
                                <a uk-tooltip="Удалить блок"  href="{{ route('blocks.delete', ['id' => $item->id]) }}"
                                   uk-icon="icon: trash">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="uk-list uk-list-striped">
                            @foreach($block->materials->sortBy('ordering') as $material)
                                @include('dashboard.materials.item')
                            @endforeach
                        </ul>
                    </div>
                    <div class="uk-text-center">
                        <div class="uk-inline">
                            <a class="uk-button uk-button-small uk-button-text" uk-tooltip="Создать материал" uk-icon="icon: plus"></a>
                            <div uk-dropdown="mode: click; pos: bottom-center">
                                @include('dashboard.materials.modal')
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a uk-tooltip="Создать блок" class="uk-button uk-button-success uk-width-1-1" uk-icon="plus" href="{{ route('blocks.create', $item->id) }}"></a>
    </section>
@endsection
