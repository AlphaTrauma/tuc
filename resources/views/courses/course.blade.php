<div>
    <div class="uk-card uk-card-default uk-card-hover uk-text-center uk-height-medium uk-card-hover-small">
        <a href="#modal-{{ $course->id }}" uk-toggle class="uk-card-media uk-height-1-1 uk-link-reset">
            @if($course->price)
                <div class="uk-card-badge uk-label uk-label-warning uk-text-bold">
                    {{ $course->price }} ₽
                </div>
            @endif
            <div class="uk-background-center-center uk-background-cover uk-overflow-hidden uk-height-1-1"
                 style='background-image: url("{{ asset($course->image->filepath)}}")'></div>
            <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-height-small uk-flex uk-flex-middle uk-flex-center">
                <p>{{ $course->title }}</p>
            </div>
        </a>
        <div id="modal-{{ $course->id }}" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h2 class="uk-modal-title">{{ $course->title }}</h2>

                <div class="uk-grid-smaill" uk-grid>
                    <div class="uk-width-1-2@l uk-flex-last@l uk-text-center">
                        <img class="uk-object-contain" src="{{ asset($course->image->filepath) }}" uk-img/>
                    </div>
                    <div class="uk-width-1-2@l">
                        @if($course->length)
                            <p><b>Продолжительность, ч.: {{ $course->length }}</b></p>
                        @endif

                        @if($course->price)
                            <p><b>Стоимость обучения: {{ $course->price }} руб.</b></p>
                        @endif
                        <p>{{ $course->description }}</p>
                    </div>
                </div>
                <div class="uk-margin-small">
                    {!! $course->html !!}
                </div>
                <a href="#modal-request" uk-toggle class="uk-button uk-button-primary uk-align-center">
                    Оставить заявку
                </a>
            </div>
        </div>
    </div>
</div>
