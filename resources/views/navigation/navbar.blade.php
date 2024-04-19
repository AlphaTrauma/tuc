<header class="">
    <div class="uk-flex uk-flex-between uk-flex-middle uk-padding-small uk-container">
        <div>
            <span class="uk-visible@s"><b>{{ $contacts['name'] }}</b></span>
        </div>
        <div class="uk-flex uk-flex-right uk-flex-middle">
            @if(session('impaired'))
                <a href="{{ route('mode') }}" class="button__impaired">
                    <strong>Обычная версия</strong>
                </a>
            @else
                <a href="{{ route('mode') }}" class="button__impaired">
                    <strong>Версия для<br>слабовидящих</strong>
                </a>
            @endif

             @auth
                 @if(Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="uk-button"><span class="uk-visible@l">Управление</span> <span class="uk-margin-left" uk-icon="icon: sign-in"></span></a>
                    <form method="POST" class="uk-flex uk-flex-middle" action="{{ route('logout') }}">
                        @csrf
                        <button class="uk-button uk-button-link uk-text-capitalize uk-width-1-1" title="Выйти" type="submit">ВЫХОД</button>
                    </form>
                @else
                    <a href="{{ route('personal') }}" class="uk-button">ЛК ({{ Auth::user()->name }})<span class="uk-margin-left" uk-icon="icon: sign-in"></span></a>
                    <form method="POST" class="uk-flex uk-flex-middle" action="{{ route('logout') }}">
                        @csrf
                        <button class="uk-button uk-button-link uk-text-capitalize uk-width-1-1" title="Выйти" type="submit">ВЫХОД</button>
                    </form>
                @endif
            @else
                <a href="/login" class="uk-button uk-button-small">Вход<span class="uk-margin-left" uk-icon="icon: sign-in"></span></a>
            @endauth
        </div>
    </div>
    <div class="uk-container-expand">
        <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky;">
            <div @if(!session('impaired')) class="uk-background-primary" @else class="impaired-nav" @endif>
                <nav class="uk-container uk-light" uk-navbar itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <div class="uk-navbar-left uk-hidden@s">
                        <a title="Меню" class="uk-navbar-item" href="#mobile-menu" uk-toggle>@if(session('impaired'))<strong class="uk-text-large">МЕНЮ</strong>@else<span uk-icon="menu"></span>@endif</a>
                    </div>
                    @if(!session('impaired'))
                    <div class="uk-navbar-left">
                        @if(Route::currentRouteName() === 'main')
                            <div class="uk-navbar-item uk-logo"><img style="max-height: 55px;" src="https://imageup.ru/img6/3890887/logo.png" alt=""></div>
                        @else
                            <a class="uk-navbar-item uk-logo" title="На главную" itemprop="url" href="{{ route('main') }}"><img style="max-height: 55px;" src="https://imageup.ru/img6/3890887/logo.png" alt=""></a>
                        @endif
                    </div>
                    @endif
                    <div class="uk-navbar-left uk-visible@s">
                        <ul class="uk-navbar-nav uk-text-bold">
                            <li @isset($page) @if(in_array($page->slug, $pages['teaching'])) class="uk-active" @endif @endisset>
                                <a uk-icon="icon: chevron-down" href="#">Обучение</a>
                                <div class="uk-navbar-dropdown uk-text-normal">
                                    <ul class="uk-nav uk-navbar-dropdown-nav">
                                        @foreach($directions as $slug => $title)
                                            <li><a itemprop="url" href="{{ asset('directions/'.$slug) }}">{{ $title }}</a></li>
                                        @endforeach
                                        <li><a itemprop="url" href="/timetable">График обучения</a></li>
                                        <li class="uk-nav-divider"></li>
                                        <li><a class="uk-text-bold" uk-toggle href="#modal-request">Оставить заявку</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li @isset($page) @if(in_array($page->slug, $pages['information'])) class="uk-active" @endif @endisset>
                                <a>Сведения об организации <span uk-icon="icon: chevron-down"></span></a>
                                <div class="uk-navbar-dropdown uk-text-normal">
                                    <ul class="uk-nav uk-navbar-dropdown-nav">
                                        <li><a itemprop="url" href="{{ route('news.main') }}">Новости и акции</a></li>
                                        <li><a itemprop="url" href="/information">Основные сведения</a></li>
                                        <li><a itemprop="url" href="/schedule">Режим работы</a></li>
                                        <li><a itemprop="url" href="/documents">Документы</a></li>
                                        <li><a itemprop="url" href="/thanks">Благодарности</a></li>

                                    </ul>
                                </div>
                            </li>
                            @isset($pricelist->document->filepath)
                                <li><a target="_blank" href="{{ asset($pricelist->document->filepath) }}">Прайс-лист <span uk-icon="icon: download"></span></a></li>
                            @endisset
                                <li>
                                    <a class="uk-button uk-button-small uk-button-danger" itemprop="url" href="/height" @if(session('impaired'))
                                    style="font-size: 15px" @else style="font-size: 12px" @endif>
                                        Учебно-тренировочный<br>стенд "Высота" <span uk-icon="icon: chevron-down"></span></a>
                                    <div class="uk-navbar-dropdown uk-text-normal">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li><a itemprop="url" href="/height">Аренда</a></li>
                                            <li><a itemprop="url" href="/height2">Обучение</a></li>
                                            <li class="uk-nav-divider"></li>
                                            <li><a class="uk-text-bold uk-text-danger" uk-toggle href="#modal-height">Оставить заявку</a></li>
                                        </ul>
                                    </div>
                                </li>
                            <li @isset($page) @if($page->slug === 'contacts') class="uk-active" @endif @endisset ><a itemprop="url" href="/contacts">Контакты</a></li>
                                <li class="uk-navbar-item phones">
                                    <ul class="uk-list">
                                        <li><a href="tel:{{ $contacts['phone'] }}">{{ $contacts['phone'] }}</a></li>
                                        <li><a href="mailto:{{ $contacts['email'] }}">{{ $contacts['email'] }}</a></li>
                                    </ul>
                                </li>
                        </ul>

                    </div>

                </nav>
            </div>
        </div>
    </div>
</header>

