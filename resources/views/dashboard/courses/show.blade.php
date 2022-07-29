@extends('layouts.dashboard')

@section('title')
    Структура курса {{ $item->title }}
@endsection

@section('content')
    <h2 class="uk-title">Конструктор курса</h2>
    @include('blocks.errors')
    <section class="uk-padding uk-padding-remove-horizontal">
        <h3>{{ $item->title }}
            <a href="?check" class="uk-button uk-button-success uk-float-right">Запустить проверку</a>
        </h3>
        <p>{{ $item->description }}</p>
        <div>
            @foreach($item->blocks as $block)
                <div class="uk-card-small uk-card-default uk-card-body uk-margin-bottom">
                    <div class=" uk-position-relative uk-margin-bottom">
                        <span>{{ $block->ordering }}. {{ $block->title }}</span>
                        <ul class="uk-iconnav uk-position-absolute uk-position-center-right uk-padding-small uk-flex-nowrap">
                            <li><a uk-tooltip="Редактировать модуль" href="{{ route('blocks.edit', $block->id) }}" uk-icon="icon: file-edit"></a></li>
                            <li><a uk-tooltip="Удалить модуль" href="{{ route('blocks.delete', ['id' => $block->id]) }}"
                                   uk-icon="icon: trash">
                                </a></li>
                        </ul>
                    </div>
                    <div>
                        <ul class="uk-list uk-list-striped">
                            @foreach($block->materials->sortBy('ordering') as $material)
                                @include('dashboard.materials.item')
                            @endforeach
                            @if($block->test)
                                <li class="uk-flex uk-flex-middle uk-flex-between @if($block->test->questions->count() > 0 and $block->test->questions->where('correct', null)->count() > 0) error-background @else uk-background-primary @endif uk-light">
                                        <div class="uk-margin-right">
                                            <span uk-tooltip="Тестирование" uk-icon="ratio: 1.2;icon: file-edit"></span>
                                            <span>{{ $block->test->title }}</span>
                                        </div>
                                        <ul class="uk-iconnav">
                                            <li><a uk-tooltip="Редактировать тест" href="{{ route('test.constructor', $block->id) }}" uk-icon="file-edit"></a></li>
                                            <li><a uk-tooltip="Удалить тест" href="{{ route('test.delete', $block->test->id) }}" uk-icon="icon: trash"></a></li>
                                        </ul>
                                    </li>
                            @endif
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
        <a uk-tooltip="Создать модуль" class="uk-button uk-button-success uk-width-1-1" uk-icon="plus" href="{{ route('blocks.create', $item->id) }}"></a>
    </section>
@endsection
