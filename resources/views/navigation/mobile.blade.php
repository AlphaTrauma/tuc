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
                <li><a class="uk-cover-container" href="#">Программы обучения</a></li>
                <li><a href="/contacts">Контакты</a></li>
                <li><a href="/timetable">График обучения</a></li>
                <li><a class="" href="/information">Основные сведения</a></li>
                <li><a href="/documents">Документы</a></li>
                <li><a href="/managers">Руководство</a></li>
                <li><a href="/teachers">Преподаватели</a></li>
            </ul>
        </div>
    </div>
</div>
