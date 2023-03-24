<li class="uk-flex uk-flex-middle uk-flex-between">
    <div class="uk-margin-right">
        <span uk-tooltip="{{ $material->type['title'] }}" uk-icon="ratio: 1.2;icon:{{ $material->type['icon'] }}"></span>
        <span>{{ $material->ordering }}. {{ $material->title }} @if($material->download) <span uk-tooltip="Доступен для скачивания" uk-icon="download"></span> @endif</span>
        @if($material->error) <span class="uk-text-danger">{{ $material->error }}</span>@endif
    </div>
    <ul class="uk-iconnav uk-width-small uk-flex-right">
            <li>
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
            </li>
            <li><a uk-tooltip="Редактировать материал" href="#rename-{{$material->id}}" uk-icon="icon: file-edit" uk-toggle></a></li>
            <div id="rename-{{$material->id}}" class="uk-flex-top" uk-modal>
                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                    <h2 class="uk-modal-title">Редактировать материал</h2>
                    <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('materials.update', $material->id) }}">
                        @csrf
                        <div class="uk-form-horizontal">
                            <div class="uk-margin">
                                <label class="uk-form-label" for="ordering">Порядковый номер</label>
                                <div class="uk-form-controls">
                                    <input type="number" name="ordering" id="ordering" placeholder="Порядковый номер" value="{{ $material->ordering }}" class="uk-input">
                                </div>
                            </div>
                        </div>
                        <div class="uk-margin">
                            <input name="title" type="text" class="uk-input" required placeholder="Название материала" value="{{ $material->title }}">
                        </div>
                        <div class="uk-margin">
                            <textarea name="description" placeholder="Описание материала" cols="30" rows="10" class="uk-textarea">{{ $material->description }}</textarea>
                        </div>
                        @if($material->material_type == 'pdf')
                            <div class="uk-margin">
                                @if($material->download)
                                    <label><input class="uk-checkbox" name="download" checked type="checkbox"> Разрешить скачивание</label>
                                @else
                                    <label><input class="uk-checkbox" name="download" type="checkbox"> Разрешить скачивание</label>
                                @endif
                            </div>
                            @isset($material->document->filepath)
                                <div class="uk-margin">
                                    <p><b>Загруженный файл:</b> {{ $material->document->filename }}</p>
                                </div>
                            @endisset
                            <div class="uk-margin">
                                <div class="uk-width-1-1" uk-form-custom="target: true">
                                    <input accept=".pdf" type="file" name="file">
                                    <input class="uk-input uk-form-width-medium uk-width-1-1" type="text" placeholder="Выбрать файл" disabled>
                                </div>
                            </div>
                        @endif
                        <input type="submit" class="uk-button uk-button-small uk-width-1-1" value="Изменить">
                    </form>
                </div>
            </div>
            <delete-button text="Удалить материал" action="{{ route('materials.delete', $material->id) }}"></delete-button>
    </ul>
</li>
