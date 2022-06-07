@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <h1 class="uk-title uk-margin-bottom">{{ $title }}</h1>
    @include('blocks.errors')
    @if(!session()->has('message'))
        <section>
            <div class="uk-card uk-card-body">
                <form action="{{ route('lead.store') }}"  method="POST" class="uk-form">
                    @csrf
                    <div class="uk-margin-small">
                        <input type="text" placeholder="Телефон (обязательно)" name="phone" required class="uk-input">
                    </div>
                    <div class="uk-margin-small">
                        <div uk-grid class="uk-grid-small uk-child-width-1-2@s">
                            <div>
                                <input type="text" placeholder="Имя" name="name" class="uk-input">
                            </div>
                            <div>
                                <input type="text" placeholder="E-Mail" name="email" class="uk-input">
                            </div>
                        </div>
                    </div>
                    <div class="uk-margin-small">
                        <textarea placeholder="Комментарий" id="" cols="30" rows="10" class="uk-textarea" name="comment"></textarea>
                    </div>
                    <div class="uk-margin-small">
                        <input type="text" value="" name="fax" id="fax" class="uk-hidden">
                        <input type="text" value="" name="theme" id="theme" class="uk-hidden">
                        <input type="text" value="" name="contact" class="uk-hidden">
                    </div>
                    <input type="hidden" name="page" value="{{ request()->url() }}">
                    <div class="uk-margin-small">
                        <input type="submit" value="Отправить" class="uk-button uk-button-primary uk-width-1-1">
                    </div>
                </form>
            </div>
        </section>
    @endif
@endsection
