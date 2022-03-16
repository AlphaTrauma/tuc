<header class="">
    <div class="uk-flex uk-flex-between uk-flex-middle uk-padding-small uk-container">
        <div>
            <b>Общество с ограниченной ответственностью
                «Тюменский Учебный Центр»</b>
        </div>
        <div style="max-width: 300px;" class="uk-flex uk-flex-right">
            @auth
                <a href="{{ route('dashboard') }}" class="uk-button">ЛК ({{ Auth::user()->name }})<span class="uk-margin-left" uk-icon="icon: sign-in"></span></a>
            @else
                <a href="/login" class="uk-button">Войти<span class="uk-margin-left" uk-icon="icon: sign-in"></span></a>
            @endauth

        </div>
    </div>
    <div class="uk-container-expand">
        <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky;">
            <div class="uk-background-primary">
                <nav class="uk-container uk-light" uk-navbar>
                    <div class="uk-navbar-left">
                        <a class="uk-navbar-item uk-logo" href="#"><img style="max-height: 55px;" src="https://imageup.ru/img6/3890887/logo.png" alt=""></a>
                        <ul class="uk-navbar-nav uk-text-bold" >
                            <li class="uk-active"><a href="#">Главная</a></li>
                            <li>
                                <a class="uk-card" href="#">Обучение</a>
                                <div class="uk-navbar-dropdown uk-text-normal">
                                    <ul class="uk-nav uk-navbar-dropdown-nav">
                                        <li><a href="#">Программы профессионального обучения</a></li>
                                        <li><a href="#">Программы дополнительного профессионального образования</a></li>
                                        <li><a href="#">График обучения</a></li>
                                        <li class="uk-nav-divider"></li>
                                        <li><a class="uk-text-bold" href="#">Оставить заявку</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#">Сведения об организации</a>
                                <div class="uk-navbar-dropdown uk-text-normal">
                                    <ul class="uk-nav uk-navbar-dropdown-nav">
                                        <li><a href="#">Основные сведения</a></li>
                                        <li><a href="#">Режим работы</a></li>
                                        <li><a href="#">Структура и органы управления образовательной деятельностью</a></li>
                                        <li><a href="#">Документы</a></li>
                                        <li><a href="#">Режим работы</a></li>
                                        <li><a href="#">Руководство, педагогический состав</a></li>
                                        <li><a href="#">Финансово-хозяйственная деятельность</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="#">Контакты</a></li>
                        </ul>

                    </div>
                    <div class="uk-navbar-right">
                        <div class="uk-navbar-item">
                            <ul class="uk-list">
                                <li><a href="tel:8 (3452) 564-919">8 (3452) 564-919</a></li>
                                <li><a href="mailto:tuc.tmn@mail.ru">tuc.tmn@mail.ru</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>


        </div>
    </div>
</header>

