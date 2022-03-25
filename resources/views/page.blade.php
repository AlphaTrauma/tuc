@extends('layouts.app')

@section('title')
    {{ $page->title }}
@endsection

@section('content')
    <h2>{{ $page->title }}</h2>
    <div class="uk-card uk-card-default uk-card-body">
        {!! $page->html  !!}
    </div>
@endsection
