<li class="uk-flex uk-flex-middle uk-flex-between">
    <div class="uk-margin-right">
        <span uk-tooltip="{{ $material->type['title'] }}" uk-icon="ratio: 1.2;icon:{{ $material->type['icon'] }}"></span>
        <span>{{ $material->ordering }}. {{ $material->title }} @if($material->download) <span uk-tooltip="Доступен для скачивания" uk-icon="download"></span> @endif</span>
    </div>
    <ul class="uk-iconnav">
        @switch($material->material_type)
            @case('pdf')
                @isset($material->document->filepath)
                    <a target="_blank" uk-tooltip="Открыть" href="{{ asset($material->document->filepath) }}" uk-icon="cloud-download"></a>
                @endisset
            @break
            @case('youtube')
                <a target="_blank" uk-tooltip="Открыть" href="https://www.youtube.com/watch?v={{ $material->url }}" uk-icon="cloud-download"></a>
            @break
            @case('link')
                <a target="_blank" uk-tooltip="Открыть" href="{{ $material->url }}" uk-icon="cloud-download"></a>
            @break
            @case('image')
                <a target="_blank" uk-tooltip="Открыть" href="{{ asset($material->image->filepath) }}" uk-icon="cloud-download"></a>
            @break
            @default
                <a uk-tooltip="Неизвестный тип материала" uk-icon="warning"></a>
        @endswitch
            <li><a uk-tooltip="Переименовать материал" href="#rename-{{$material->id}}" uk-icon="icon: file-edit" uk-toggle></a></li>
            <div id="rename-{{$material->id}}" class="uk-flex-top" uk-modal>
                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                    <h2 class="uk-modal-title">Переименовать материал</h2>
                    <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('materials.update', $material->id) }}">
                        @csrf
                        <div class="uk-margin">
                            <input name="title" type="text" class="uk-input" required placeholder="Название материала" value="{{ $material->title }}">
                        </div>
                        <div class="uk-margin">
                            <textarea name="description" placeholder="Описание материала" cols="30" rows="10" class="uk-textarea">{{ $material->description }}</textarea>
                        </div>
                        <input type="submit" class="uk-button uk-button-small uk-width-1-1" value="Переименовать">
                    </form>
                </div>
            </div>
            <li>
                <a uk-tooltip="Удалить материал"  href="{{ route('materials.delete', $material->id) }}"
                   uk-icon="icon: trash">
                </a>
            </li>
    </ul>
</li>