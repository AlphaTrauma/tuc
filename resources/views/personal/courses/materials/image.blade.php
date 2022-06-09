@extends('layouts.personal')

@section('content')
    @include('personal.courses.materials.nav')
    <h2>{{ $material->title }}</h2>
    <p>{{ $material->description }}</p>
    <div class="uk-padding uk-padding-remove-horizontal uk-text-center">
        <img uk-image src="{{ asset($material->image->filepath) }}" alt="{{ $material->title }}">
    </div>
@endsection
