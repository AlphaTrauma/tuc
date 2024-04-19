@extends('layouts.dashboard')

@section('title')
    Заявки по курсу "{{ \App\Models\Lead::$types[$type] }}"
@endsection

@section('content')
    <h1>Заявки по курсу "{{ \App\Models\Lead::$types[$type] }}"</h1>
    @include('blocks.errors')
    <table class="uk-table uk-table-divider">
        <thead>
        <tr>
            <th>Телефон</th>
            <th>Имя</th>
            <th>Email</th>

            <th>Комментарий</th>
            <th>Время</th>
            <th>Пользователь</th>
            <th style="min-width: 30px;"></th>
        </tr>
        </thead>
        <tbody>
    @foreach($groups as $lead_group)
            @isset($items[$lead_group->id])
                <tr>
                    <th class="uk-text-center" colspan="7">
                            Заявки в группу <span class="uk-text-secondary uk-text-bold">{{ $lead_group->course_date->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }} -
                        {{ $lead_group->course_date->addDays(1)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                        </span></th>
                </tr>
                @foreach($items[$lead_group->id] as $item)
                    <tr>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td style="word-wrap: break-word; max-width: 300px;">{{ $item->comment }}</td>
                        <td>{{ $item->created_at->diffForHumans() }}</td>
                        <td>
                            @if(!$item->user)
                                <a class="uk-button uk-button-small uk-button-danger" type="button" uk-toggle="target: #lead-{{ $item->id }};
                        animation: uk-animation-fade">Зарегистрировать</a>
                                <div hidden  id="lead-{{ $item->id }}" class="uk-margin-auto-vertical">
                                    <form class="uk-padding-small" enctype=multipart/form-data method="POST" action="{{ route('users.add') }}">
                                        @csrf

                                        <div>
                                            <div uk-grid class="uk-grid-small uk-child-width-1-2@s">
                                                <input class="uk-input" type="text" name="name" required placeholder="Имя (обязательно)">
                                                <input class="uk-input" type="text" name="patronymic" placeholder="Отчество">
                                            </div>
                                            <div uk-grid class="uk-grid-small uk-child-width-1-2@s">
                                                <input class="uk-input" type="text" name="last_name" value="{{ $item->name }}" required placeholder="Фамилия (обязательно)">
                                                <input class="uk-input uk-button-small" type="text" name="phone" value="{{ $item->phone }}" placeholder="Телефон">
                                            </div>
                                        </div>
                                        <input type="hidden" name="lead_id" value="{{ $item->id }}">

                                        <div class="uk-margin-small uk-text-center">
                                            <input type="submit" class="uk-button uk-button-secondary" value="Зарегистрировать">
                                        </div>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('user.show', $item->user_id) }}" class="uk-button uk-button-small uk-button-success">Пользователь</a>
                            @endif
                        </td>
                        <td>
                            @if(!$item->status)
                                <a href="{{ route('lead.read', $item) }}" title="Отметить как прочитанную" class="uk-text-danger">Не обработана</a>
                            @else
                                <span class="uk-text-success">Обработана</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endisset

    @endforeach
    <tr>
        <th class="uk-text-center" colspan="7">
            <span class="uk-text-secondary uk-text-bold">Заявки без указания группы</span>
        </th>
    </tr>
    @foreach($items[""] as $item)
        <tr>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td style="word-wrap: break-word; max-width: 300px;">{{ $item->comment }}</td>
            <td>{{ $item->created_at->diffForHumans() }}</td>
            <td>
                @if(!$item->user)
                    <a class="uk-button uk-button-small uk-button-danger" type="button" uk-toggle="target: #lead-{{ $item->id }};
                        animation: uk-animation-fade">Зарегистрировать</a>
                    <div hidden  id="lead-{{ $item->id }}" class="uk-margin-auto-vertical">
                        <form class="uk-padding-small" enctype=multipart/form-data method="POST" action="{{ route('users.add') }}">
                            @csrf

                            <div>
                                <div uk-grid class="uk-grid-small uk-child-width-1-2@s">
                                    <input class="uk-input" type="text" name="name" required placeholder="Имя (обязательно)">
                                    <input class="uk-input" type="text" name="patronymic" placeholder="Отчество">
                                </div>
                                <div uk-grid class="uk-grid-small uk-child-width-1-2@s">
                                    <input class="uk-input" type="text" name="last_name" value="{{ $item->name }}" required placeholder="Фамилия (обязательно)">
                                    <input class="uk-input uk-button-small" type="text" name="phone" value="{{ $item->phone }}" placeholder="Телефон">
                                </div>
                            </div>
                            <input type="hidden" name="lead_id" value="{{ $item->id }}">

                            <div class="uk-margin-small uk-text-center">
                                <input type="submit" class="uk-button uk-button-secondary" value="Зарегистрировать">
                            </div>
                        </form>
                    </div>
                @else
                    <a href="{{ route('user.show', $item->user_id) }}" class="uk-button uk-button-small uk-button-success">Пользователь</a>
                @endif
            </td>
            <td>
                @if(!$item->status)
                    <a href="{{ route('lead.read', $item) }}" title="Отметить как прочитанную" class="uk-text-danger">Не обработана</a>
                @else
                    <span class="uk-text-success">Обработана</span>
                @endif
            </td>
        </tr>
    @endforeach
        </tbody>
    </table>

@endsection
