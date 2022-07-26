@extends('layouts.personal')

@section('content')
    <h1>{{ $test->title }}</h1>
    <p>{{ $test->description }}</p>
    <form action="" method="post">
        @csrf
        @foreach($test->questions as $question)
            <div class="uk-card uk-card-small uk-card-default uk-margin-bottom">
                <div class="uk-card-header">
                    <h4>{{ $question->text }}</h4>
                </div>
                <div class="uk-card-body">
                    <ul class="uk-list-striped uk-list">
                        @foreach($question->variants as $index => $variant)
                            <li>
                                <input required name="{{ $question->id }}" value="{{ $variant->id }}" class="uk-radio" type="radio"> {{ $variant->text }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
        <input type="submit" class="uk-button uk-button-success" value="Завершить тест">
    </form>
@endsection
