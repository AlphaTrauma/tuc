<footer class="uk-background-secondary uk-section-small">
    <div class="uk-container">
        <div class="uk-flex uk-flex-between">
            <div class="uk-visible@s">
                <ul class="uk-nav uk-nav-default">
                    <li class="uk-nav-header">
                        <a href="/all_directions">Обучение</a>
                    </li>
                    @foreach($directions as $slug => $title)
                        <li><a href="{{ asset('directions/'.$slug) }}">{{ $title }}</a></li>
                    @endforeach
                    <li>
                        <a href="/timetable">График занятий</a>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-text-bold" uk-toggle href="#modal-request">Оставить заявку</a></li>
                </ul>
            </div>
            <div class="uk-visible@s">
                <ul class="uk-nav uk-nav-default">
                    <li class="uk-nav-header"><a href="">Об организации</a></li>
                    <li><a href="/information">Основные сведения</a></li>
                    <li><a href="/schedule">Режим работы</a></li>
                    <li><a href="/documents">Документы</a></li>
                    <li><a href="/managers">Руководство</a></li>
                    <li><a href="/teachers">Преподаватели</a></li>
                </ul>
            </div>
            <div>
                <ul class="uk-nav uk-nav-default">
                    <li class="uk-nav-header uk-visible@s">
                        <a href="/contacts">Контакты</a>
                    </li>
                    <li><a href="tel:83452564919">8 (3452) 564-919</a></li>
                    <li><a href="mailto:tuc.tmn@mail.ru">tuc.tmn@mail.ru</a></li>
                    <li>Российская Федерация, г. Тюмень, ул. Одесская, д. 48-А/2</li>
                    <li>ООО «Тюменский Учебный Центр»</li>
                    <li>ИНН: 7203459280</li>
                    <li>ОГРН: 1187232024154</li>
                    <li>Лицензия: 456783568-45673</li>
                    <li>Приём претензий по адресу: г. Тюмень, ул. Одесская, д. 48-А/2</li>
                </ul>
            </div>
        </div>

    </div>
    <div class="uk-container">
        <div class="uk-float-right uk-flex uk-flex-center">
            @if(Route::currentRouteName() === 'main')
                <div class="uk-logo"><img style="max-height: 35px;"  src="https://imageup.ru/img6/3890887/logo.png" alt=""></div>
            @else
                <a class="uk-logo" href="{{ route('main') }}"><img style="max-height: 35px;" src="https://imageup.ru/img6/3890887/logo.png" alt=""></a>
            @endif

            <span class="uk-padding-small uk-padding-remove-vertical">ООО «ТУЦ», 2018-{{ date('Y') }}</span>
        </div>
    </div>
</footer>
