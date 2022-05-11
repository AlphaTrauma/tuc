<section>
    @if(Route::currentRouteName() === 'main')
        <h2 class="uk-title uk-text-center">
            Направления обучения
        </h2>
        <hr>
    @endif
    <div class="uk-child-width-1-3@s uk-grid-match uk-padding uk-padding-remove-horizontal" uk-grid>
        @foreach($items as $item)
            <div>
                <a title="{{ $item->title }} в Тюменском Учебном Центре" href="{{ asset('directions/'.$item->slug) }}" class="uk-transition-toggle uk-link-reset uk-card uk-card-default uk-card-hover">
                    <div class="uk-card-media-top">
                        <div class="uk-overflow-hidden" tabindex="0">
                            <div class=" uk-transition-scale-up uk-transition-opaque uk-height-medium uk-width-expand uk-background-cover uk-background-center-center"
                                 style='background-image: url("{{ asset($item->image->filepath) }}");'>
                            </div>
                        </div>

                            {{--<div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                <img class="uk-transition-scale-up uk-transition-opaque uk-object-cover" data-src="{{ asset($item->image->filepath) }}"
                                     data-width="1000" data-height="667" alt="{{ $item->title }} в Тюменском Учебном Центре" uk-img="">
                            </div>--}}
                    </div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title">{{ $item->title }}</h3>
                        <p>{{ $item->description }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</section>
