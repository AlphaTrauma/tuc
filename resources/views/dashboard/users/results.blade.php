@extends('layouts.dashboard')

@section('title')
    Результаты тестов пользователя {{ $userCourse->user->name }}
@endsection

@section('content')
    <h1>Результаты тестов пользователя {{ $userCourse->user->name }}</h1>
    <p><small>Курс: {{ $userCourse->course->title }}</small></p>
    <p>Правильные ответы выделены зелёным, неправильные красным. Корректные варианты помечены галочкой. Если на странице нет никаких результатов и текста причины, значит, в курсе отсутствуют тесты.</p>
    @forelse($userCourse->user_blocks as $user_block)
        @if($user_block->block->test and $user_block->user_test)
            @php $questions = $user_block->block->test->questions @endphp
            <h2>Название теста: {{ $user_block->block->test->title }}:</h2>
            @if($user_block->user_test->user_answers->count() < 1)
                <p>Пользователь прошёл текст до ведения статистики по последней попытке</p>
            @elseif($user_block->user_test->user_answers->count() < $questions->count())
                <p>Пользователь не закончил прохождение теста</p>
            @else
                @foreach($questions as $question)
                    @php $user_answer = $user_block->user_test->user_answers->where('question_id', $question->id)->first();
                    @endphp
                    <div class="uk-card uk-card-default uk-card-small  uk-margin-bottom">
                        <div class="uk-card-header uk-background-muted">
                            <b>{{ $question->text }}</b>
                        </div>
                        <div class="uk-card-body">

                            <ul class="uk-list uk-list-divider">
                                @foreach($question->variants as $variant)
                                    @if($question->correct === $variant->id and $user_answer->variant_id  === $variant->id)
                                        <li class="uk-text-success uk-text-bold">{{ $variant->text }}
                                            @if($question->correct === $variant->id) <span uk-icon="check"></span> @endif
                                        </li>
                                    @elseif($question->correct !== $variant->id and $user_answer->variant_id  === $variant->id)
                                        <li class="uk-text-danger uk-text-bold">{{ $variant->text }}
                                            @if($question->correct === $variant->id) <span uk-icon="check"></span> @endif
                                        </li>
                                    @else
                                        <li>{{ $variant->text }}
                                            @if($question->correct === $variant->id) <span uk-icon="check"></span> @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                    </div>
                @endforeach
            @endif
        @endif
    @empty
        <p>Курс был не доработан и добавлен пользователю, либо произошла ошибка.</p>
    @endforelse
@endsection
