@if(Route::currentRouteName() !== 'main')
<ul class="uk-breadcrumb">
        <li><a href="{{ route('main') }}">Главная</a></li>
    @isset($item->alias)
        <li><a href="{{ $item->alias['path'] }}">{{ $item->alias['title'] }}</a></li>
    @endisset
    @isset($item->title)
        <li><a>{{ $item->title }}</a></li>
    @endisset
</ul>
@endif
