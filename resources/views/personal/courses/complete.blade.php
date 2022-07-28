@extends('layouts.personal')

@section('content')
    <h1>Завершённые курсы:</h1>
    <table class="uk-table uk-table-striped">
        @forelse($items as $user_course)
            <div class="uk-card uk-card-default uk-card-body uk-margin-bottom">
                <h2 class="uk-card-title">{{ $user_course->course->title }} ({{ $user_course->course->length }}
                    часов)
                </h2>
                <a href="{{ route('personal.course', $user_course->id) }}" class="uk-button uk-button-primary">Открыть курс</a>
            </div>
        @empty
            <tr>
                <td>Завершённые курсы отсутствуют.</td>
                <td></td>
            </tr>
        @endforelse
    </table>
@endsection
