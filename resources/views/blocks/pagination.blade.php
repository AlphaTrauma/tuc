
@if ($paginator->hasPages())
    <ul class="uk-pagination">

        @if ($paginator->onFirstPage())
            <li class="uk-disabled"><span>← Назад</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Назад</a></li>
        @endif



        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="uk-disabled"><span>{{ $element }}</span></li>
            @endif


            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="uk-active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach



        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Дальше →</a></li>
        @else
            <li class="uk-disabled"><span>Дальше →</span></li>
        @endif
    </ul>
@endif
