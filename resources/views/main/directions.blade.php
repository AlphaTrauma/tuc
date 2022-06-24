<section>
    @if(Route::currentRouteName() === 'main')
        <h2 class="uk-title uk-text-center">
            Обучение
        </h2>
        <hr>
    @endif
    <div>
        @foreach($items as $type)
            <div class="uk-margin-bottom">
                <a class="uk-card uk-card-default uk-child-width-1-1 uk-card-hover"
                   uk-toggle="target: #directions-{{$type->id}}; animation: uk-animation-slide-top-medium">
                    <div class="uk-panel uk-height-medium uk-background-cover uk-background-center-center"
                         style="background-image: url({{ asset($type->image->filepath) }})">
                        <div class="uk-overlay uk-overlay-default uk-position-center">
                            <h2>{{ $type->title }}</h2>
                        </div>
                    </div>
                </a>

                <div {{ $loop->first ? '' : 'hidden' }} id="directions-{{$type->id}}" class="uk-child-width-1-3@s uk-grid-match uk-padding-small uk-padding-remove-horizontal" uk-grid>
                    @foreach($type->directions as $direction)
                        <div>
                            <a title="{{ $direction->title }} в Тюменском Учебном Центре" href="{{ asset('directions/'.$direction->slug) }}" class="uk-transition-toggle uk-link-reset uk-card uk-card-default uk-card-hover">
                                <div class="uk-card-media-top">
                                    <div class="uk-overflow-hidden" tabindex="0">
                                        <div class=" uk-transition-scale-up uk-transition-opaque uk-height-medium uk-width-expand uk-background-cover uk-background-center-center"
                                             style='background-image: url("{{ asset($direction->image->filepath) }}");'>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title">{{ $direction->title }}</h3>
                                    <p>{{ $direction->description }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</section>
