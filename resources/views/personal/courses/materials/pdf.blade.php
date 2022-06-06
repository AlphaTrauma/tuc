@extends('layouts.personal')

@section('content')
    <h2>{{ $material->title }}</h2>
    <p>{{ $material->description }}</p>
    @include('personal.courses.materials.nav')
    <div class="uk-padding uk-padding-remove-horizontal">
        <embed class="uk-width-1-1 uk-height-viewport" src="{{ asset($material->document->filepath) }}" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
    </div>
@endsection
