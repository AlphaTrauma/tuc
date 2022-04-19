@extends('layouts.app')

@section('title')
    {{ $item->title }}
@endsection

@section('content')
    <section>
        <div uk-grid class="uk-grid">
            <div class="uk-width-1-2@s uk-flex-last@l">
                <img src="{{ asset($item->image->filepath) }}" alt="">
            </div>
            <div class="uk-width-1-2@s">
                <h1>{{ $item->title }}</h1>
                @if($item->html)
                    <div class="uk-margin-small">
                        {!! $item->html !!}
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section>
        <h2>{{ $item->title }}, все курсы:</h2>
        <div class="uk-padding uk-padding-remove-horizontal uk-card-hover-small">
            <div class="uk-child-width-1-3@m uk-grid uk-grid-match" uk-grid>
                @for($i = 0; $i <= 8; $i++)
                    <div>
                        <div class="uk-card uk-card-default uk-text-center">
                            <div class="uk-card-media">
                                <img src="/images/placeholder.png" uk-img/>
                                <div class="uk-overlay uk-overlay-primary uk-position-bottom">
                                    <p>Курс {{ $i + 1 }}</p>
                                    <a class="uk-button uk-button-small uk-button-default" href="#modal-{{ $i }}" uk-toggle>Подробнee</a>
                                </div>
                            </div>
                            <div class="uk-card-body">

                                <div id="modal-{{ $i }}" class="uk-flex-top" uk-modal>
                                    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                                        <button class="uk-modal-close-default" type="button" uk-close></button>
                                        <h2 class="uk-modal-title">Название курса</h2>

                                        <div class="uk-grid-smaill" uk-grid>
                                            <div class="uk-width-1-2@l uk-flex-last@l uk-text-center">
                                                <img class="uk-object-contain" src="/images/placeholder.png" uk-img/>
                                            </div>
                                            <div class="uk-width-1-2@l">
                                                <p><b>Полное описание курса</b></p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <a href="#modal-request" uk-toggle class="uk-button uk-button-danger uk-align-center">
                                            Оставить заявку
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

@endsection
