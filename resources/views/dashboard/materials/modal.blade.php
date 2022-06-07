<ul class="uk-nav uk-dropdown-nav">
    <li><a href="#create-pdf-{{$block->id}}" uk-toggle>PDF</a></li>
    <li><a href="#create-youtube-{{$block->id}}" uk-toggle>Видео с youtube</a></li>
    <li><a href="#create-link-{{$block->id}}" uk-toggle>Ссылка</a></li>
    <li><a href="#create-image-{{$block->id}}" uk-toggle>Изображение</a></li>
    <li class="uk-nav-divider"></li>
    <li><a class="uk-disabled">Текстовый материал</a></li>
    <li><a class="uk-disabled">Видео</a></li>
    <li><a class="uk-disabled"><b>Тестирование</b></a></li>
</ul>

<div id="create-pdf-{{$block->id}}" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <h2 class="uk-modal-title">Прикрепить документ PDF</h2>
        <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('materials.store') }}">
            <input type="hidden" name="material_type" value="pdf">
            <input type="hidden" name="block_id" value="{{ $block->id }}">
            @csrf
            <div class="uk-margin">
                <input type="text" name="title" class="uk-input" required placeholder="Название материала">
            </div>
            <div class="uk-margin">
                <textarea name="description" placeholder="Описание материала" id="" cols="30" rows="10" class="uk-textarea"></textarea>
            </div>
            <div class="uk-margin">
                <div class="uk-width-1-1" uk-form-custom="target: true">
                    <input accept=".pdf" type="file" required name="file">
                    <input class="uk-input uk-form-width-medium uk-width-1-1" type="text" placeholder="Выбрать файл" disabled>
                </div>
            </div>
            <input type="submit" class="uk-button uk-button-small uk-width-1-1" value="Прикрепить">
        </form>
    </div>
</div>

<div id="create-youtube-{{$block->id}}" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <h2 class="uk-modal-title">Прикрепить видео с Youtube</h2>
        <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('materials.store') }}">
            <input type="hidden" name="material_type" value="youtube">
            <input type="hidden" name="block_id" value="{{ $block->id }}">
            @csrf
            <div class="uk-margin">
                <input name="title" type="text" class="uk-input" required placeholder="Название материала">
            </div>
            <div class="uk-margin">
                <textarea name="description" placeholder="Описание материала" id="" cols="30" rows="10" class="uk-textarea"></textarea>
            </div>
            <div class="uk-margin uk-text-center">
                <input type="text" class="uk-input" name="url" required placeholder="Идентификатор видео или полная ссылка">
            </div>
            <input type="submit" class="uk-button uk-button-small uk-width-1-1" value="Прикрепить">
        </form>
    </div>
</div>

<div id="create-link-{{$block->id}}" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <h2 class="uk-modal-title">Прикрепить ссылку</h2>
        <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('materials.store') }}">
            <input type="hidden" name="material_type" value="link">
            <input type="hidden" name="block_id" value="{{ $block->id }}">
            @csrf
            <div class="uk-margin">
                <input name="title" type="text" class="uk-input" required placeholder="Название материала">
            </div>
            <div class="uk-margin">
                <textarea name="description" placeholder="Описание материала" id="" cols="30" rows="10" class="uk-textarea"></textarea>
            </div>
            <div class="uk-margin uk-text-center">
                <input type="text" class="uk-input" name="url" required placeholder="Ссылка на внешний ресурс">
            </div>
            <input type="submit" class="uk-button uk-button-small uk-width-1-1" value="Прикрепить">
        </form>
    </div>
</div>

<div id="create-image-{{$block->id}}" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <h2 class="uk-modal-title">Прикрепить изображение</h2>
        <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('materials.store') }}">
            <input type="hidden" name="material_type" value="pdf">
            <input type="hidden" name="block_id" value="{{ $block->id }}">
            @csrf
            <div class="uk-margin">
                <input name="title" type="text" class="uk-input" required placeholder="Название материала">
            </div>
            <div class="uk-margin">
                <textarea name="description" placeholder="Описание материала" id="" cols="30" rows="10" class="uk-textarea"></textarea>
            </div>
            <div class="uk-margin uk-text-center">
                <upload></upload>
            </div>
            <input type="submit" class="uk-button uk-button-small uk-width-1-1" value="Прикрепить">
        </form>
    </div>
</div>
