@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div itemscope itemtype="http://schema.org/Article">
        <h1 class="uk-title uk-margin-bottom" itemprop="headline">{{ $title }}</h1>
        <section class="uk-padding uk-padding-small uk-padding-remove-horizontal">
            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                <div class="uk-card-media-left uk-cover-container">
                    <img src="http://туц.рф/images/height/preview.jpg" alt="" uk-cover>
                    <canvas width="600" height="400"></canvas>
                </div>
                <div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title">Оставьте заявку на очное обучение</h3>
                        <p>Пройдите двухдневный обучающий курс с использованием стенда "Высота". Вы можете сразу выбрать желаемые даты обучения из списка ближайших занятий.</p>
                        <a class="uk-button uk-button-danger" uk-toggle href="#modal-height">Оставить заявку</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="uk-padding uk-padding-small uk-padding-remove-horizontal">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body">
                   <p>
                       С этого года на базе нашего УЦ организован полигон «Высота», для очного обучения, прохождения стажировки и отработки навыков по «‎Безопасным методам и приемам выполнения работ на высоте».
                   </p>
                    <p>Мы предлагаем:</p>
                    <ul>
                        <li>
                            Обучение под ключ «Высота»<br>
                            (Обучение состоит из теоретической и практической частей и проводятся соответствующим требованиям педагогическим составом).
                        </li>
                        <li>
                            Аренду оснащенного класса в г. Тюмень для проведения стажировки и отработки навыков сотрудников по «Безопасным методам и приемам выполнения работ на высоте».<br>
                            По адресу ул. Республики д.209
                        </li>
                    </ul>
                    <p>
                        <strong>
                            Стоимость обучения от 3000 до 5000 рублей, зависит от количества заявленных сотрудников.
                        </strong>
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection
