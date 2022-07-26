<header class="">
    <div class="uk-flex uk-flex-between uk-flex-middle uk-padding-small uk-container">
        <div>
            <span class="uk-visible@s"><b>{{ $contacts['name'] }}</b></span>
        </div>
        <div class="uk-flex uk-flex-right">
             @auth
                 @if(Auth::user()->isAdmin())
                    <a href="{{ route('dashboard') }}" class="uk-button">Управление сайтом <span class="uk-margin-left" uk-icon="icon: sign-in"></span></a>
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
            <div class="uk-background-primary">
                <nav class="uk-container uk-light" uk-navbar itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <div class="uk-navbar-left uk-hidden@s">
                        <a title="Меню" class="uk-navbar-item" href="#mobile-menu" uk-toggle><span uk-icon="menu"></span></a>
                    </div>
                    <div class="uk-navbar-left">
                        @if(Route::currentRouteName() === 'main')
                            <div class="uk-navbar-item uk-logo"><img style="max-height: 55px;" src="https://imageup.ru/img6/3890887/logo.png" alt=""></div>
                        @else
                            <a class="uk-navbar-item uk-logo" itemprop="url" href="{{ route('main') }}"><img style="max-height: 55px;" src="https://imageup.ru/img6/3890887/logo.png" alt=""></a>
                        @endif
                    </div>
                    <div class="uk-navbar-left uk-visible@s">
                        <ul class="uk-navbar-nav uk-text-bold">
                            @if(Route::currentRouteName() === 'main')
                                <li class="uk-active"><a>Главная</a></li>
                            @else
                                <li><a itemprop="url" href="{{ route('main') }}">Главная</a></li>
                            @endif
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
                                <a uk-icon="icon: chevron-down">Сведения об организации</a>
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
                            <li><a target="_blank" href="{{ asset('/uploads/documents/Прейскурант цен НК ООО ТУЦ.pdf') }}" uk-icon="icon: download">Прайс-лист</a></li>
                            <li @isset($page) @if($page->slug === 'contacts') class="uk-active" @endif @endisset ><a itemprop="url" href="/contacts">Контакты</a></li>
                        </ul>

                    </div>

                    <div class="uk-navbar-right">
                        {{--
                         <div class="uk-navbar-item">
                            <a href="" class="uk-button">Позвоните мне</a>
                        </div>
                         --}}
                        <div class="uk-navbar-item">
                            <ul class="uk-list">
                                <li><a href="tel:{{ $contacts['phone'] }}">{{ $contacts['phone'] }}</a></li>
                                <li><a href="mailto:{{ $contacts['email'] }}">{{ $contacts['email'] }}</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

