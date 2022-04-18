@extends('layouts.dashboard')

@section('title')
    Список направлений обучения
@endsection

@section('content')
    <h2>Направления:</h2>
    @include('dashboard.errors')
    <div class="uk-padding-small">
        <a href="{{ route('directions.create') }}" class="uk-button uk-button-primary"><span class="uk-margin-small-right" uk-icon="plus"></span>Создать</a>
    </div>
    <div class="uk-padding-small">
        @forelse($items as $item)
            <div class="uk-card uk-card-default uk-margin-bottom">
                <div class="uk-card-body uk-flex">
                    <div class="uk-card-title uk-text-center uk-width-3-4">{{ $item->title }}</div>
                    <div class="uk-width-1-4">
                        <ul class="uk-iconnav uk-float-right">
                            <li><a href="{{ route('course.create', ['id' => $item->id]) }}" title="Добавить курс" uk-icon="icon: plus"></a></li>
                            <li><a title="Редактировать направление" href="{{ route('directions.edit', ['direction' => $item]) }}" uk-icon="icon: file-edit"></a></li>
                            <li><a title="Удалить направление"  href="{{ route('directions.destroy', ['direction' => $item]) }}" uk-icon="icon: trash"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <p>Направления обучения не найдены</p>
        @endforelse
    </div>
@endsection
