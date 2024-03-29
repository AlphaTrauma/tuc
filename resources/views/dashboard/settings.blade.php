@extends('layouts.dashboard')

@section('title')
    Настройки сайта
@endsection

@section('content')
    <h1>Настройки сайта</h1>
    @include('blocks.errors')
    <hr>
    <div class="uk-form-horizontal">
        <h2>Список сотрудников</h2>
        <div class="uk-margin">
            <label class="uk-form-label" for="list">Список</label>
            <div class="uk-form-controls">
                <ul class="uk-list uk-list-divider">
                    @forelse($personnel as $person)
                        <li>

                            {{ $person->name }}
                            <a href="{{ route('person.remove', $person) }}" class="uk-link uk-text-danger"><span uk-icon="close"></span></a>
                        </li>
                    @empty
                        <li>Сотрудники не добавлены</li>
                    @endforelse
                    <li>
                        <form action="{{ route('person.add') }}" method="POST">
                            @csrf
                            <div  class="uk-flex uk-width-large">
                                <input required class="uk-input" name="name" id="person" type="text" placeholder="Фамилия И.О." value="">
                                <input type="submit" class="uk-button uk-button-success" value="Добавить">
                            </div>

                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-form-horizontal">
        <h2>Список должностей</h2>
        <div class="uk-margin">
            <label class="uk-form-label" for="list">Список</label>
            <div class="uk-form-controls">
                <ul class="uk-list uk-list-divider">
                    @forelse($positions as $position)
                        <li>

                            {{ $position->name }}
                            <a href="{{ route('position.remove', $position) }}" class="uk-link uk-text-danger"><span uk-icon="close"></span></a>
                        </li>
                    @empty
                        <li>Должности не добавлены</li>
                    @endforelse
                    <li>
                        <form action="{{ route('position.add') }}" method="POST">
                            @csrf
                            <div  class="uk-flex uk-width-large">
                                <input required class="uk-input" name="name" id="person" type="text" placeholder="Название" value="">
                                <input type="submit" class="uk-button uk-button-success" value="Добавить">
                            </div>

                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <hr>
    <form class="uk-form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('settings.save') }}">
        @csrf
        <h2>Контакты и реквизиты</h2>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="shortname">Краткое название компании</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="shortname" id="shortname" type="text" value="{{ $settings['shortname']->value }}">
            </div>
        </div>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="name">Полное название компании</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="name" id="fname" type="text" value="{{ $settings['name']->value }}">
            </div>
        </div>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="phone">Номер телефона</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="phone" id="phone" type="text" value="{{ $settings['phone']->value }}">
            </div>
        </div>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="email">Адрес электронной почты</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="email" id="email" type="text" value="{{ $settings['email']->value }}">
            </div>
        </div>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="address">Юридический адрес</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="address" id="address" type="text" value="{{ $settings['address']->value }}">
            </div>
        </div>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="post">Почтовый адрес</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="post" id="post" type="text"  value="{{ $settings['post']->value }}">
            </div>
        </div>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="INN">ИНН</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="INN" id="INN" type="text"  value="{{ $settings['INN']->value }}">
            </div>
        </div>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="OGRN">ОГРН</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="OGRN" id="OGRN" type="text"  value="{{ $settings['OGRN']->value }}">
            </div>
        </div>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="license">Лицензия</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="license" id="license" type="text"  value="{{ $settings['license']->value }}">
            </div>
        </div>
        <hr>
        <h2>Прайс-лист</h2>
        @isset($settings['pricelist']->document->filepath)
            <p>Загруженный файл: <a class="uk-link-text" href="{{ asset($settings['pricelist']->document->filepath) }}">
                {{ $settings['pricelist']->document->filename }}</a>
            </p>
        @endisset
        <div class="uk-margin">
            <div class="uk-width-1-1" uk-form-custom="target: true">
                <input accept=".pdf" type="file" required name="file">
                <input class="uk-input uk-form-width-medium uk-width-1-1" type="text" placeholder="Выбрать файл" disabled>
            </div>
        </div>
        <hr>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="director">Директор</label>
            <div class="uk-form-controls">
                <input class="uk-input" name="director" id="director" type="text"  value="{{ $settings['director']->value }}">
            </div>
        </div>
        <hr>
        <h2>Системные</h2>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="metric">Идентификатор Я.Метрики</label>
            <div class="uk-form-controls">
                <input class="uk-input" name="metric" id="metric" type="text"  value="{{ $settings['metric']->value }}">
            </div>
        </div>
        <div class="uk-margin-small">
            <label class="uk-form-label" for="recipient">Адрес для получения заявок</label>
            <div class="uk-form-controls">
                <input class="uk-input" required name="recipient" id="recipient" type="text"  value="{{ $settings['recipient']->value }}">
            </div>
        </div>
        <div class="uk-margin">
            <input type="submit" class="uk-button uk-button-success uk-width-1-1" value="Сохранить изменения">
        </div>
    </form>




@endsection
