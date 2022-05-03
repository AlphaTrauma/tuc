@extends('layouts.dashboard')

@section('title')
    Редактирование страницы
@endsection

@section('content')
    <div class="uk-card uk-card-body">
        <h2 class="uk-title">Редактирование страницы</h2>
        <form class="uk-form" method="POST" action="{{ route('pages.update', $item) }}">
            @csrf
            <div class="uk-margin uk-flex">
                <input class="uk-input" value="{{ $item->title }}" name="title" placeholder="Название страницы">
                <input class="uk-input uk-form-width-medium" value="{{ $item->slug }}" name="slug" placeholder="Ссылка">
            </div>
            <editor content="{{ $item->html }}" image="image"
            ></editor>
            <div class="uk-margin">
                <input class="uk-button uk-button-secondary uk-width-1-1" value="Сохранить" type="submit">
            </div>
        </form>
    </div>
@endsection
