<section>
    <div class="uk-slider-container" uk-slider="autoplay: true">

        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

            <ul class="uk-slider-items uk-child-width-1-1@s uk-grid">
                @foreach($slides as $item)
                    <li>
                        <a class="uk-link-reset uk-card uk-height-medium uk-position-relative" href="{{ $item->link }}">
                            <div class="uk-panel">
                                <img uk-img src="{{ asset($item->image->filepath) }}" alt="{{ $item->title }}">
                                <div  class="uk-position-bottom-left uk-padding">
                                    <h2 uk-slider-parallax="y: -50, 50; x: 50, -50" class="uk-heading text-shadow ">{{ $item->title }}</h2>
                                    @if($item->description)
                                        <div uk-slider-parallax="y: 50, -50; x: -50, 50"
                                             class="slider-text uk-padding-small uk-display-inline-block">{{ $item->description }}</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>

            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

        </div>

        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

    </div>
</section>
