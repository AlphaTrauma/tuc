<div id="mobile-menu" uk-offcanvas="overlay: true; selPanel: .uk-offcanvas-bar-light;">
    <div class="uk-offcanvas-bar-light">

        <button class="uk-offcanvas-close" type="button" uk-close></button>
        <div class="uk-offcanvas-container">
            <ul class="uk-list uk-list-divider uk-link-text ">
                <li @if(\Route::currentRouteName() === 'personal.active')class="uk-active"@endif><a href="{{ route('personal.active') }}">Активные курсы</a></li>
                <li @if(\Route::currentRouteName() === 'personal.closed')class="uk-active"@endif><a href="{{ route('personal.closed') }}">Завершённые курсы</a></li>
                <li><a href="{{ route('main') }}">Вернуться на сайт</a></li>

            </ul>
        </div>
        <form method="POST" class="uk-flex uk-flex-middle uk-position-bottom-center uk-margin-bottom" action="{{ route('logout') }}">
            @csrf
            <button class="uk-button uk-button-link uk-width-1-1" title="Выйти" type="submit">Выйти из учётной записи</button>
        </form>
    </div>
</div>
