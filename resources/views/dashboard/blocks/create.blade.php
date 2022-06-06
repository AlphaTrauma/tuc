@extends('layouts.dashboard')

@section('title')
    @isset($item)Редактирование@elseСоздание@endisset блока
@endsection

@section('content')
    @include('blocks.errors')
    <h2 class="uk-title">@isset($item)Редактировать@elseСоздать@endisset блок ({{ isset($item) ? $item->course->title : $course->title }})</h2>
    <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ isset($item) ? route('blocks.update', $item->id) : route('blocks.store') }}">
        @isset($item)
            @method('PATCH')
        @endisset
        @csrf
        <input type="hidden" name="course_id" value="{{ isset($item) ? $item->course->id : $course->id }}">
            <div class="uk-margin-small">
                <input class="uk-input" value="{{ isset($item) ? $item->title : old('title')}}" name="title" placeholder="Название блока">
            </div>
            <div class="uk-margin-small">
                <textarea name="description" placeholder="Краткое описание блока" id="" cols="30" rows="10" class="uk-textarea">{{ isset($item) ? $item->description : old('description')}}</textarea>
            </div>
        <div class="uk-margin">
            <input class="uk-button uk-button-secondary uk-width-1-1" value="Сохранить" type="submit">
        </div>
    </form>
@endsection
