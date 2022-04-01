<div id="mobile-menu" uk-offcanvas="overlay: true;">
    <div class="uk-offcanvas-bar">

        <button class="uk-offcanvas-close" type="button" uk-close></button>
        <h3>Мобильное меню</h3>
        <div class="uk-width-1-2@s uk-width-2-5@m">
            <ul class="uk-nav-default uk-nav-parent-icon" uk-nav="multiple: true">
                @if(Route::currentRouteName() === 'main')
                    <li class="uk-active"><a>Главная</a></li>
                @else
                    <li><a href="{{ route('main') }}">Главная</a></li>
                @endif
                <li class="uk-parent" @isset($page) @if(in_array($page->slug, $pages['teaching'])) class="uk-active" @endif @endisset>
                    <a href="#">Обучение</a>
                    <ul class="uk-nav-sub">
                        <li><a href="#">Программы профессионального обучения</a></li>
                        <li><a href="/timetable">График обучения</a></li>
                    </ul>
                </li>
                <li class="uk-parent">
                    <a href="#" @isset($page) @if(in_array($page->slug, $pages['information'])) class="uk-active" @endif @endisset>Сведения об организации</a>
                    <ul class="uk-nav-sub">
                        <li><a class="" href="/information">Основные сведения</a></li>
                        <li><a href="/schedule">Режим работы</a></li>
                        <li><a href="/structure">Структура и органы управления образовательной деятельностью</a></li>
                        <li><a href="/documents">Документы</a></li>
                        <li><a href="/managers">Руководство</a></li>
                        <li><a href="/teachers">Преподаватели</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
