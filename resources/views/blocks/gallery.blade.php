<div class="uk-child-width-1-5@s uk-padding" uk-grid uk-lightbox="animation: slide">
    @foreach($item->images as $image)
        <div>
            <a class="uk-inline uk-card uk-card-hover" href="{{ asset($image->filepath) }}">
                <img src="{{ asset($image->filepath) }}" alt="{{ $item->title }}, Тюменский учебный центр">
            </a>
        </div>
    @endforeach
</div>
