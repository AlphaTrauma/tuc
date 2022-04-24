@extends('layouts.dashboard')

@section('title')
    @isset($item)Редактирование@elseСоздание@endisset страницы
@endsection

@section('content')
    <div class="uk-card uk-card-body">
        <h2 class="uk-title">@isset($item)Редактировать@elseСоздать@endisset страницу</h2>
        <form class="uk-form" method="POST" action="{{ isset($item) ? route('pages.update', ['id' => $item->id]) : route('pages.store') }}">
            @csrf
            <div class="uk-margin uk-flex">
                <input class="uk-input" value="{{ isset($item) ? $item->title : old('title')}}" name="title" placeholder="Название страницы">
                <input class="uk-input uk-form-width-medium" value="{{ isset($item) ? $item->slug : old('slug')}}" name="slug" placeholder="Ссылка">
            </div>
            <editor content="{{ isset($item) ? $item->html : '' }}" image="image"
            ></editor>
            <div class="uk-margin">
                <input class="uk-button uk-button-secondary uk-width-1-1" value="Сохранить" type="submit">
            </div>
        </form>
    </div>
@endsection
