<div class="uk-background-secondary uk-width-medium" uk-height-viewport="expand">
    <div class="uk-card uk-card-body">
        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
            <li><a class="uk-text-bold" href="{{ route('main') }}"><span class="uk-margin-small-right" uk-icon="icon: home"></span>На сайт</a></li>
            <li class="uk-nav-divider"></li>
            <li class="uk-parent">
                <a class="uk-text-bold" href="#"><span class="uk-margin-small-right" uk-icon="icon: users"></span>Пользователи</a>
                <ul class="uk-nav-sub">
                    {{-- TODO
                    <li><a>Зарегистрировать</a></li>
                    --}}
                    <li><a href="{{ route('users') }}">Список</a></li>
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
                    <li><a href="">Документы</a></li>
                </ul>
            </li>
            <li><a href="{{ route('leads') }}" class="uk-text-bold"><span class="uk-margin-small-right" uk-icon="icon: commenting"></span>
                    Заявки
                    @if($leads_count > 0)
                        <div class="uk-inline-block uk-width-expand"><span class="uk-badge uk-label-danger uk-float-right">{{$leads_count}}</span></div>
                    @endif
                </a></li>
            <li><a href="{{ route('settings') }}" class="uk-text-bold"><span class="uk-margin-small-right" uk-icon="icon: cog"></span>Настройки</a></li>
        </ul>
    </div>
</div>
