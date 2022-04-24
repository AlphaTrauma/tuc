@if(Route::currentRouteName() !== 'main')
<ul class="uk-breadcrumb">
        <li><a href="{{ route('main') }}">Тюменский учебный центр</a></li>
    @isset($item->alias)
        @if($item->alias['path'])
            <li><a href="{{ $item->alias['path'] }}">{{ $item->alias['title'] }}</a></li>
        @endif
    @endisset
    @isset($item->title)
        <li><a>{{ $item->title }}</a></li>
    @else
        @isset($title)
            <li><a>{{ $title }}</a></li>
        @endisset
    @endisset
</ul>
@endif
