@extends('layouts.personal')

@section('content')
    <h2>{{ $material->title }}</h2>
    <p>{{ $material->description }}</p>
    @include('personal.courses.materials.nav')
    <div class="uk-padding uk-padding-remove-horizontal uk-text-center">
        <a class="uk-button uk-button-primary" href="{{ $material->url }}">Открыть материал</a>
    </div>
@endsection
