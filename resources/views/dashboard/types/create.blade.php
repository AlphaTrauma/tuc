@extends('layouts.dashboard')

@section('title')
    @isset($item)Редактирование@elseСоздание@endisset формы обучения
@endsection

@section('content')
    @include('blocks.errors')
    <h2 class="uk-title">@isset($item)Редактировать@elseСоздать@endisset форму обучения</h2>
    <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ isset($item) ? route('types.update', $item->id) : route('types.store') }}">
        @isset($item)
            @method('PATCH')
        @endisset
        @csrf
        <div class="uk-flex">
            <div class="uk-width-1-1">
                <div class="uk-margin-small">
                    <input class="uk-input" required value="{{ isset($item) ? $item->title : old('title')}}" name="title" placeholder="Название формы обучения">
                </div>
                <div class="uk-margin-small">
                    <textarea name="description" placeholder="Краткое описание" id="" cols="30" rows="10" class="uk-textarea">{{ isset($item) ? $item->description : old('description')}}</textarea>
                </div>
            </div>
        </div>
        <div class="uk-padding uk-padding-remove-horizontal">
            <div style="background-color: silver" class="uk-height-medium">
                <upload image="{{ isset($item->image->filepath) ? asset($item->image->filepath) : '' }}"></upload>
            </div>
        </div>


        <editor content="{{ isset($item) ? $item->html : '' }}"></editor>
        <div class="uk-margin">
            <input class="uk-button uk-button-secondary uk-width-1-1" value="Сохранить" type="submit">
        </div>
    </form>
@endsection
