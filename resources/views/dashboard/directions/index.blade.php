@extends('layouts.dashboard')

@section('title')
    Список направлений обучения
@endsection

@section('content')
    <h2>Направления:</h2>
    @include('blocks.errors')
    <div class="uk-padding-small">
        <a href="{{ route('directions.create') }}" class="uk-button uk-button-primary"><span class="uk-margin-small-right" uk-icon="plus"></span>Создать</a>
    </div>
    <div class="uk-padding-small">
        @forelse($items as $item)
            <div class="uk-margin-bottom">
                <div class="uk-card uk-card-small uk-card-primary uk-margin-bottom">
                    <div class="uk-card-body uk-flex uk-position-relative">
                        <div class="uk-card-title uk-text-center">{{ $item->title }}</div>
                        <ul class="uk-iconnav uk-position-absolute uk-position-center-right uk-padding-small">
                            <li><a href="{{ route('course.create', ['id' => $item->id]) }}" title="Добавить курс" uk-icon="icon: plus"></a></li>
                            <li><a title="Редактировать направление" href="{{ route('directions.edit', ['direction' => $item]) }}" uk-icon="icon: file-edit"></a></li>
                            <li>
                                <a title="Удалить направление"  href="{{ route('directions.delete', ['id' => $item->id]) }}"
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
                                    <li><a title="Редактировать курс" href="{{ route('courses.edit', ['course' => $course]) }}" uk-icon="icon: file-edit"></a></li>
                                    <li><a title="Удалить курс"  href="{{ route('courses.delete', ['id' => $course->id]) }}" uk-icon="icon: trash"></a></li>
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
