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
                <th style="min-width: 30px;"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($items->items() as $item)
                <tr @if(!$item->status) class="uk-alert-primary" @endif>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ str_replace("xn--r1acj.xn--p1ai", "туц.рф", $item->page) }}</td>
                    <td style="word-wrap: break-word; max-width: 300px;">{{ $item->comment }}</td>
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
    {{ $items->links() }}
@endsection
