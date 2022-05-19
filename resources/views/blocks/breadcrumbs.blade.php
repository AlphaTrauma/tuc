@if(Route::currentRouteName() !== 'main')
<ul class="uk-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="{{ route('main') }}"><span itemprop="name">Тюменский учебный центр</span></a>
            <meta itemprop="position" content="1" />
        </li>
    @isset($item->alias)
        @if($item->alias['path'])
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="{{ $item->alias['path'] }}"><span itemprop="name">{{ $item->alias['title'] }}</span></a>
                <meta itemprop="position" content="2" />
            </li>
        @endif
    @endisset
    @isset($item->title)
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a itemprop="item"><span itemprop="name">{{ $item->title }}</span></a>
            <meta itemprop="position" content="3" />
        </li>
    @else
        @isset($title)
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item"><span itemprop="name">{{ $title }}</span></a>
                <meta itemprop="position" content="2" />
            </li>
        @endisset
    @endisset
</ul>
@endif
