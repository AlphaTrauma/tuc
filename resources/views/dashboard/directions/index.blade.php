@extends('layouts.dashboard')

@section('title')
     Список направлений
@endsection

@section('content')
    <h2>@isset($type){{ $type->title }}@elseНаправления@endisset:</h2>
    @include('blocks.errors')
    <div class="uk-padding-small">
        @isset($type)
        <a href="{{ route('direction.create', $type->id) }}" class="uk-button uk-button-primary"><span class="uk-margin-small-right" uk-icon="plus"></span>Создать</a>
        @else
            <a href="{{ route('directions.create') }}" uk-tooltip="Скорее всего, вы видите эту кнопку из-за неправильного перехода на страницу"
               class="uk-button uk-button-primary"><span class="uk-margin-small-right" uk-icon="plus"></span>Создать без привязки к типу</a>
        @endisset
    </div>
    <div class="uk-padding-small">
        @forelse($items as $item)
            <div class="uk-margin-bottom">
                <div class="uk-card uk-card-small uk-card-primary uk-margin-bottom">
                    <div class="uk-card-body uk-flex uk-position-relative">
                        <div class="uk-card-title uk-text-center">{{ $item->title }}</div>
                        <ul class="uk-iconnav uk-position-absolute uk-position-center-right uk-padding-small">
                            <li><a href="{{ route('course.create', ['id' => $item->id]) }}" uk-tooltip="Добавить курс" uk-icon="icon: plus"></a></li>
                            <li><a uk-tooltip="Редактировать направление" href="{{ route('directions.edit', ['direction' => $item]) }}" uk-icon="icon: file-edit"></a></li>
                            <li>
                                <a uk-tooltip="Удалить направление"  href="{{ route('directions.delete', ['id' => $item->id]) }}"
                                   uk-icon="icon: trash">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <table class="uk-table uk-table-striped">
                    @forelse($item->courses as $course)
                        <tr class="">
                            <td><b>{{ $course->title }}</b></td>
                            <td>{{ $course->length }}ч</td>
                            <td>{{ $course->price ? $course->price.'₽' : '' }}</td>
                            <td>
                                <ul class="uk-iconnav uk-flex-right uk-flex-nowrap">
                                    <li><a href="{{ route('courses.show', ['course' => $course]) }}" uk-tooltip="Конструктор курса" uk-icon="icon: album"></a></li>
                                    <li><a uk-tooltip="Редактировать курс" href="{{ route('courses.edit', ['course' => $course]) }}" uk-icon="icon: file-edit"></a></li>
                                    <li><a uk-tooltip="Удалить курс"  href="{{ route('courses.delete', ['id' => $course->id]) }}" uk-icon="icon: trash"></a></li>
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>Курсы отсутствуют. Чтобы добавить новый, нажмите на иконку <span uk-icon="plus"></span> или <a href="{{ route('course.create', ['id' => $item->id]) }}" class="uk-link">сюда</a></td>
                        </tr>
                    @endforelse
                </table>



            </div>
        @empty
            <p>Направления обучения не найдены</p>
        @endforelse
            {{ $items->links('blocks.pagination') }}
    </div>
@endsection
