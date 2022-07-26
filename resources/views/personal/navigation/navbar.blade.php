<div class="uk-box-shadow-medium uk-container-expand">
    <nav uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky;" class="uk-navbar-container uk-container" uk-navbar>

        <div class="uk-navbar-left uk-visible@s">
            <ul class="uk-navbar-nav">
                <li>
                    <a uk-icon="icon: chevron-down" href="#">Мои курсы</a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li @if(\Route::currentRouteName() === 'personal.active')class="uk-active"@endif><a href="{{ route('personal.active') }}">Активные</a></li>
                            <li @if(\Route::currentRouteName() === 'personal.closed')class="uk-active"@endif><a href="{{ route('personal.closed') }}">Завершённые</a></li>
                        </ul>
                    </div>
                </li>
                <li hidden><a href="#">Статистика</a></li>
            </ul>

        </div>
        <div class="uk-navbar-left uk-hidden@s">
            <a title="Меню" class="uk-navbar-item" href="#mobile-menu" uk-toggle><span uk-icon="menu"></span></a>
        </div>
        <div class="uk-navbar-center uk-padding uk-padding-remove-vertical uk-visible@s">
            <img style="max-height: 80px;" src="https://imageup.ru/img6/3890887/logo.png" uk-logo alt="">
        </div>

        <div class="uk-navbar-right">

            <ul class="uk-navbar-nav">
                <li><a>{{ Auth::user()->email }} <span class="uk-margin-small-left" uk-icon="icon: user"></span></a></li>
                <li><a uk-tooltip="Выйти из ЛК" href="{{ route('main') }}"><span uk-icon="icon: sign-out"></span></a></li>
            </ul>

        </div>

    </nav>
</div>

