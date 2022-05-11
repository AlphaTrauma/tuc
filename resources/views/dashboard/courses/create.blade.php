@extends('layouts.dashboard')

@section('title')
    @isset($item)Редактирование@elseСоздание@endisset курса
@endsection

@section('content')
    @include('blocks.errors')
    <h2 class="uk-title">@isset($item)Редактировать@elseСоздать@endisset курс ({{ isset($item) ? $item->direction->title : $direction->title }})</h2>
    <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ isset($item) ? route('courses.update', $item->id) : route('courses.store') }}">
        @isset($item)
            @method('PATCH')
        @endisset
        @csrf
            <input type="hidden" name="direction_id" value="{{ isset($item) ? $item->direction->id : $direction->id }}">
        <div class="uk-flex">
            <div class="uk-width-1-3">
                <div class="uk-margin-small">
                    <input class="uk-input" value="{{ isset($item) ? $item->title : old('title')}}" name="title" placeholder="Название курса">
                </div>
                <div class="uk-margin-small">
                    <input type="number" value="{{ isset($item) ? $item->length : old('length')}}" placeholder="Количество часов" name="length" class="uk-input">
                </div>
                <div class="uk-margin-small">
                    <input type="number" value="{{ isset($item) ? $item->price : old('price')}}" placeholder="Стоимость" name="price" class="uk-input">
                </div>
                <div class="uk-margin-small">
                    <textarea name="description" placeholder="Краткое описание" id="" cols="30" rows="10" class="uk-textarea">{{ isset($item) ? $item->description : old('description')}}</textarea>
                </div>
            </div>
            <div class="uk-width-2-3 uk-padding-small uk-padding-remove-vertical">
                <upload image="{{ isset($item->image->filepath) ? asset($item->image->filepath) : '' }}"></upload>
            </div>
        </div>


        <editor content="{{ isset($item) ? $item->html : '' }}"></editor>
        <div class="uk-margin">
            <input class="uk-button uk-button-secondary uk-width-1-1" value="Сохранить" type="submit">
        </div>
    </form>
@endsection
