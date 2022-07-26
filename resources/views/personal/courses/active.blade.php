@extends('layouts.personal')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <h1>{{ $title }}:</h1>
    <table class="uk-table uk-table-striped">
        @forelse($items as $user_course)
            <div class="uk-card uk-card-default uk-card-body">
                <h2 class="uk-card-title">{{ $user_course->course->title }} ({{ $user_course->course->length }}
                    часов)
                </h2>
                <a href="{{ route('personal.course', $user_course->id) }}" class="uk-button uk-button-primary">Открыть курс</a>
            </div>
                @empty
                    <tr>
                        <td>Курсы отсутствуют.</td>
                        <td>
                            <a href="/all_directions"
                               class="uk-button uk-button-small uk-button-success uk-float-right">Выбрать</a>
                        </td>
                    </tr>
        @endforelse
    </table>
@endsection
