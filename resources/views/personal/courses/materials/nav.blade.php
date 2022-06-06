<div class="uk-position-relative uk-margin-bottom uk-padding uk-padding-remove-horizontal">
    @if($user_material->previous())
        <a href="{{ route('material.show', $user_material->previous()->id) }}" class="uk-button uk-button-success uk-float-left">Назад</a>
    @endif
    @if($user_material->next())
        <a href="{{ route('material.show', $user_material->next()->id) }}" class="uk-button uk-button-success uk-float-right">Далее</a>
    @endif


</div>
