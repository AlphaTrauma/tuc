<div id="mobile-menu" uk-offcanvas="overlay: true; selPanel: .uk-offcanvas-bar-light;">
    <div class="uk-offcanvas-bar-light">

        <button class="uk-offcanvas-close" type="button" uk-close></button>
        <div class="uk-offcanvas-container">
            <ul class="uk-list uk-list-divider uk-link-text">
                @if(Route::currentRouteName() === 'main')
                    <li><b>Главная</b></li>
                @else
                    <li><a class="uk-cover-container" href="{{ route('main') }}">Главная</a></li>
                @endif
                @foreach($directions as $slug => $title)
                        <li><a href="{{ asset('directions/'.$slug) }}">{{ $title }}</a></li>
                @endforeach

                <li><a href="/news">Новости</a></li>
                <li><a href="/contacts">Контакты</a></li>
                <li><a href="/timetable">График обучения</a></li>
                <li><a class="" href="/information">Основные сведения</a></li>
                <li><a href="/documents">Документы</a></li>
                <li><a href="/thanks">Благодарности</a></li>
            </ul>
        </div>
    </div>
</div>
