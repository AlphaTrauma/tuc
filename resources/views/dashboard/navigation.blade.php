<div class="uk-background-secondary uk-width-medium" uk-height-viewport="expand">
    <div class="uk-card uk-card-body">
        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
            <li><a class="uk-text-bold" href="{{ route('main') }}"><span class="uk-margin-small-right" uk-icon="icon: home"></span>На сайт</a></li>
            <li class="uk-nav-divider"></li>
            <li class="uk-parent">
                <a class="uk-text-bold" href="#"><span class="uk-margin-small-right" uk-icon="icon: users"></span>Пользователи</a>
                <ul class="uk-nav-sub">
                    <li><a uk-toggle href="#modal-disabled">Зарегистрировать</a></li>
                    <li><a href="{{ route('users') }}">Список</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a class="uk-text-bold" href="#"><span class="uk-margin-small-right" uk-icon="icon: table"></span>Обучение</a>
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('directions.index') }}">Список направлений</a></li>
                    <li><a href="{{ route('courses.index') }}">Список курсов</a></li>
                    <li><a uk-toggle href="#modal-disabled">Статистика</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a class="uk-text-bold" href="#"><span class="uk-margin-small-right" uk-icon="icon: world"></span>Контент</a>
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('slider') }}">Слайдер</a></li>
                    <li><a href="{{ route('pages') }}">Страницы</a></li>
                    <li><a uk-toggle href="#modal-disabled">Новости</a></li>
                </ul>
            </li>
            <li>
                <a class="uk-text-bold" href="{{ route('images.index') }}"><span class="uk-margin-small-right" uk-icon="icon: folder"></span>Файлы</a>
            </li>
            <li><a uk-toggle href="#modal-disabled" class="uk-text-bold"><span class="uk-margin-small-right" uk-icon="icon: social"></span>Контакты</a></li>
            <li><a uk-toggle href="#modal-disabled" class="uk-text-bold"><span class="uk-margin-small-right" uk-icon="icon: cog"></span>Настройки</a></li>
        </ul>
    </div>
</div>
