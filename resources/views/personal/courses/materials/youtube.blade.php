@extends('layouts.personal')

@section('content')
    <h2>{{ $material->title }}</h2>
    @include('personal.courses.materials.nav')
    <div class="uk-padding">
        <iframe class="uk-width-1-1 uk-height-viewport" src="https://www.youtube.com/embed/{{ $material->url }}" title="{{ $material->title }}"
                frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>

        </iframe>
    </div>
@endsection
