<div class="uk-box-shadow-medium uk-container-expand">
    <nav class="uk-navbar-container uk-container" uk-navbar>

        <div class="uk-navbar-left">

            <ul class="uk-navbar-nav">
                <li>
                    <a uk-icon="icon: chevron-down" href="#">Мои курсы</a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li class="uk-active"><a href="{{ route('personal.active') }}">Активные</a></li>
                            <li><a href="#">Оконченные</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="#">Статистика</a></li>
            </ul>

        </div>
        <div class="uk-navbar-center uk-padding uk-padding-remove-vertical">
            <img style="max-height: 80px;" src="https://imageup.ru/img6/3890887/logo.png" uk-logo alt="">
        </div>

        <div class="uk-navbar-right">

            <ul class="uk-navbar-nav">
                <li><a>{{ Auth::user()->email }} <span class="uk-margin-small-left" uk-icon="icon: user"></span></a></li>
                <li><a href="{{ route('main') }}"><span uk-icon="icon: sign-out"></span></a></li>
            </ul>

        </div>

    </nav>
</div>

