@extends('layouts.dashboard')

@section('title')
    Управление курсами и направлениями
@endsection

@section('content')
    <h2 class="uk-title">Управление курсами</h2>
    <div>
        <table class="uk-table uk-table-striped">
            @forelse($items as $course)
                <tr class="">
                    <td><b>{{ $course->title }}</b></td>
                    <td>{{ $course->length }} часов</td>
                    <td>{{ $course->price ? $course->price.'₽' : '' }}</td>
                    <td>{{ $course->direction->title }}</td>
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
                    <td>Курсы отсутствуют. Чтобы добавить новый, перейдите в раздел направлений</td>
                </tr>
            @endforelse
        </table>
        {{ $items->links('blocks.pagination') }}
    </div>
@endsection
