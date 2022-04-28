@extends('layouts.dashboard')

@section('title')
    Редактирование новости
@endsection

@section('content')

    <div class="uk-card uk-card-body">
        <h2 class="uk-title">Редактировать новость</h2>
        <form class="uk-form" method="POST" action="{{ route('news.update', $item->id) }}">
            @csrf
            @method('PUT')
            <div class="uk-margin-small uk-flex">
                <input class="uk-input" value="{{ $item->title }}" name="title" placeholder="Название">
                <input class="uk-input uk-form-width-medium" value="{{ $item->slug }}" name="slug" placeholder="Ссылка">
            </div>
            <div class="uk-margin-small">
                <textarea name="text" placeholder="Краткое описание" id="" cols="30" rows="10" class="uk-textarea">{{ $item->text }}</textarea>
            </div>
            <editor content="{{ $item->html }}" image="image"></editor>
            <div class="uk-margin">
                <div class="">Привязать курсы:</div>
            </div>
            <div class="uk-margin">
                <courses-select :id="{{ $item->id }}"></courses-select>
            </div>
            <div class="uk-margin">
                <input class="uk-button uk-button-secondary uk-width-1-1" value="Сохранить" type="submit">
            </div>
        </form>
    </div>
@endsection
