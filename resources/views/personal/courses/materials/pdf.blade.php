@extends('layouts.personal')

@section('content')
    @include('personal.courses.materials.nav')

    <h2>{{ $material->title }}
        @if($material->download)
            <a href="{{ asset($material->document->filepath) }}" download class="uk-button uk-button-primary uk-float-right">Скачать<span class="uk-margin-small-left" uk-icon="download"></span></a></p>
        @endif
    </h2>
    <p>{{ $material->description }}</p>

    <div class="uk-padding uk-padding-remove-horizontal">
        <embed class="uk-width-1-1 uk-height-viewport" src="{{ asset($material->document->filepath) }}" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
    </div>
@endsection
