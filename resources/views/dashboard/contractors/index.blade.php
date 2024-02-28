@extends('layouts.dashboard')

@section('content')
    <h1>Список контрагентов</h1>
    @include('blocks.errors')
    <div class="uk-margin">
        <button class="uk-button uk-button-success" type="button" uk-toggle="target: #form; animation: uk-animation-fade">
            Создать контрагента
        </button>
    </div>
    <div hidden id="form">
        <form action="{{ route('contractors.create') }}" method="POST" class="uk-grid-small uk-width-1-2" uk-grid>
            @csrf
            <div class="uk-width-1-2">
                <input class="uk-input" type="text" name="short_name" placeholder="Короткое название" required>
            </div>
            <div class="uk-width-1-2">
                <input type="text" class="uk-input" name="name" placeholder="Полное название компании" required>
            </div>
            <div class="uk-width-1-2">
                <input type="text" class="uk-input" name="TIN" placeholder="ИНН">
            </div>
            <div class="uk-width-1-2">
                <input class="uk-input" type="text" name="description" placeholder="Описание">
            </div>
            <div class="uk-width-1-1">
                <input type="submit" class="uk-button uk-button-success" value="Добавить">
            </div>

        </form>
    </div>
    @foreach($items as $item)
        <div class="uk-card uk-card-default uk-padding-small  uk-margin-top uk-width-1-1">
            <a class="uk-link uk-link-text" href="{{ route('contractor', $item) }}"><b>{{ $item->short_name }}</b> @if($item->name) ({{ $item->name }}) @endif</a>
            <span class="uk-float-right"><delete-button action="{{ route('contractors.remove', $item->id) }}"  text="Удалить"></delete-button></span>
            <div>INN: <i>{{ $item->TIN }}</i></div>
            <div>{{ $item->description }}</div>
        </div>
    @endforeach


@endsection
