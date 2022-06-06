<div class="uk-background-secondary uk-width-medium" uk-height-viewport="expand">
    <div class="uk-card uk-card-body">
        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
            <li><a class="uk-text-bold" href="{{ route('main') }}"><span class="uk-margin-small-right" uk-icon="icon: home"></span>На сайт</a></li>
            <li class="uk-nav-divider"></li>
            <li><a href="{{ route('dashboard') }}" class="uk-text-bold"><span class="uk-margin-small-right" uk-icon="icon: settings"></span>Панель</a>
            </li>
            <li class="uk-parent">
                <a class="uk-text-bold" href="#"><span class="uk-margin-small-right" uk-icon="icon: users"></span>Пользователи</a>
                <ul class="uk-nav-sub">
                    <li><a>Зарегистрировать</a></li>
                    <li><a href="{{ route('students') }}">Студенты</a></li>
                    <li><a href="{{ route('users') }}">Полный список</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a class="uk-text-bold" href="#"><span class="uk-margin-small-right" uk-icon="icon: table"></span>Обучение</a>
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('directions.index') }}">Список направлений</a></li>
                    <li><a href="{{ route('courses.index') }}">Список курсов</a></li>
                    {{--TODO
                     <li><a>Статистика</a></li>
                     --}}
                </ul>
            </li>
            <li class="uk-parent">
                <a class="uk-text-bold" href="#"><span class="uk-margin-small-right" uk-icon="icon: world"></span>Контент</a>
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('slider') }}">Слайдер</a></li>
                    <li><a href="{{ route('pages') }}">Страницы</a></li>
                    <li><a href="{{ route('news.index') }}">Новости и акции</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a class="uk-text-bold"><span class="uk-margin-small-right" uk-icon="icon: folder"></span>Файлы</a>
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('images.index') }}">Изображения</a></li>
                    {{-- TODO
                     <li><a href="">Документы</a></li>
                     --}}
                </ul>
            </li>
            <li><a href="{{ route('leads') }}" class="uk-text-bold"><span class="uk-margin-small-right" uk-icon="icon: commenting"></span>
                    Заявки
                    @if($leads_count > 0)
                        <div class="uk-inline-block uk-width-expand"><span class="uk-badge uk-label-danger uk-float-right">{{$leads_count}}</span></div>
                    @endif
                </a></li>
            <li><a href="{{ route('settings') }}" class="uk-text-bold"><span class="uk-margin-small-right" uk-icon="icon: cog"></span>Настройки</a></li>

            <li class="uk-grid-small uk-flex-middle uk-padding-small" uk-grid>
                <div>
                    <div class="uk-background-center-center uk-background-cover uk-border-circle"
                         style="background-image: url({{ isset(Auth::user()->image->filepath) ? asset(Auth::user()->image->filepath) : '' }});
                             width: 50px;
                             height: 50px;
                             ">
                    </div>
                </div>
                <div class="uk-width-expand uk-position-relative">
                    <p class="uk-comment-meta uk-margin-remove">{{ Auth::user()->name }}</p>
                    <p class="uk-comment-meta uk-margin-remove">{{ Auth::user()->email }}</p>
                <div class="uk-position-center-right uk-inline">
                    <a class="uk-link-reset"><span uk-icon="triangle-down"></span></a>
                    <div uk-dropdown="mode:click; offset: 10; pos: bottom-right;" class="uk-padding-small">
                        <ul uk-nav class="uk-dropdown-nav uk-nav">
                            <li>
                                <a class="uk-flex-center" href="{{ route('user.show', Auth::id()) }}">Профиль</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="uk-button uk-button-link uk-text-capitalize uk-width-1-1" type="submit">Выйти</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                </div>
            </li>

        </ul>
    </div>
</div>
