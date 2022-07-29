@extends('layouts.dashboard')

@section('title')
    Зарегистрированные пользователи сайта
@endsection

@section('content')
    <h2>Список пользователей</h2>
    @include('blocks.errors')
    @include('dashboard.users.actions')
    @forelse($users as $user)
        <div class="uk-card uk-card-default uk-padding-small uk-card-body uk-margin-top uk-width-1-1">
            <div><span class="uk-margin-right"><b>#{{ $user->id }}</b></span><span class="uk-icon" uk-icon="icon: user"></span> {{ $user->name }} {{ $user->patronymic }} {{ $user->last_name }} <span class="uk-icon" uk-icon="icon: email"></span> <i>{{ $user->email }}</i></div>
            <ul class="uk-iconnav uk-width-small uk-card-badge uk-background-default uk-flex-right">
                <li><a uk-tooltip="Открыть профиль" href="{{ route('user.show', $user->id) }}" uk-icon="icon: user"></a></li>
                <li><a uk-tooltip="Редактировать данные" href="{{ route('user.edit', $user->id) }}" uk-icon="icon: file-edit"></a></li>
                <li><a uk-tooltip="Удалить пользователя" href="#" uk-icon="icon: trash"></a></li>
            </ul>
        </div>
    @empty
        <p>Результатов не найдено</p>
    @endforelse
    {{ $users->links('blocks.pagination') }}
@endsection
