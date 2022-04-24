@extends('layouts.dashboard')

@section('title')
    Заявки
@endsection

@section('content')
    <h1>Заявки с форм сайта</h1>
    @if($items->count() > 0)
        <table class="uk-table uk-table-hover uk-table-divider">
            <thead>
            <tr>
                <th>Телефон</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Страница</th>
                <th>Комментарий</th>
                <th>Время</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr @if(!$item->status) class="uk-alert-primary" @endif>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->page }}</td>
                    <td>{{ $item->comment }}</td>
                    <td>{{ $item->created_at->diffForHumans() }}</td>
                    <td>
                        @if(!$item->status)
                            <a href="{{ route('lead.read', $item) }}" title="Отметить как прочитанную" uk-icon="icon: check"></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Заявок пока нет.</p>
    @endif
@endsection
