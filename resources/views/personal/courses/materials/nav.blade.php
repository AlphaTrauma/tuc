<div class="uk-position-relative uk-padding-small uk-padding-remove-horizontal">

    <div class="uk-flex uk-flex-middle uk-flex-between">
        <div>
            @if($user_material->previous())
                <a uk-tooltip="Перейти к предыдущему материалу модуля" href="{{ route('material.show', $user_material->previous()->id) }}" class="uk-button uk-button-text uk-float-left">
                    <span uk-icon="arrow-left" class="uk-margin-small-right"></span>Предыдущий материал
                </a>
            @else
                @php($prev_block = $user_material->user_block->previous())
                @if($prev_block)
                    <a href="{{ route('material.show', $prev_block->last_material()->id) }}" class="uk-button uk-button-text uk-float-left">
                        <span uk-icon="arrow-left" class="uk-margin-small-right"></span>Предыдущий модуль
                    </a>
                @endif
            @endif
        </div>
        <div>
            <h4 class="uk-heading uk-heading-line">{{ $user_material->user_block->block->course->title }}</h4>
            <ul class="uk-nav uk-nav-default uk-width-large">
                <li class="uk-nav-header">{{ $user_material->user_block->block->ordering }}. {{ $user_material->user_block->block->title }}
                    @if($user_material->user_block->status)
                        <span uk-icon="check" class="uk-text-success"></span>
                    @endif
                </li>
                @foreach($user_material->user_block->user_materials as $item)
                    <li><a @if($user_material->id === $item->id) class="uk-disabled uk-text-bold"
                           @else href="{{ route('material.show', $item->id) }}"
                            @endif>
                            {{ $item->material->ordering }}. {{ $item->material->title }}
                            @if($item->status)
                                <span class="uk-text-success" uk-icon="check"></span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            @if($user_material->next())
                <a uk-tooltip="Перейти к следующему материалу модуля" href="{{ route('material.show', $user_material->next()->id) }}" class="uk-button uk-button-text uk-float-right">
                    Следующий материал<span uk-icon="arrow-right" class="uk-margin-small-left"></span>
                </a>
            @else
                @php($next_block = $user_material->user_block->next())
                @if($next_block)
                    <a href="{{ route('material.show', $next_block->first_material()->id) }}" class="uk-button uk-button-text uk-float-left">
                        Следующий модуль<span uk-icon="arrow-right" class="uk-margin-small-left"></span>
                    </a>
                @endif
            @endif
        </div>
    </div>


</div>
