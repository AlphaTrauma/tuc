<div id="modal-request" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Оставить заявку</h2>
        </div>
        <div class="uk-modal-body">
            <form action="{{ route('lead.store') }}" method="POST" class="uk-form">
                @csrf
                <div class="uk-margin-small">
                    <input type="text" placeholder="Телефон (обязательно)" name="phone" required class="uk-input">
                </div>
                <div class="uk-margin-small">
                    <div uk-grid class="uk-grid-small uk-child-width-1-2@s">
                        <div>
                            <input type="text" placeholder="Имя" name="name" class="uk-input">
                        </div>
                        <div>
                            <input type="text" placeholder="E-Mail" name="email" class="uk-input">
                        </div>
                    </div>

                </div>
                <div class="uk-margin-small">

                </div>
                <div class="uk-margin-small">
                    <textarea placeholder="Комментарий" id="" cols="30" rows="10" class="uk-textarea" name="comment"></textarea>
                </div>
                <input type="hidden" name="page" value="{{ request()->url() }}">
                <div class="uk-margin-small">
                    <input type="submit" value="Отправить" class="uk-button uk-button-primary uk-width-1-1">
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal-disabled" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-body">
            <p class="uk-text-uppercase">Функционал находится на стадии разработки</p>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-primary uk-modal-close" type="button">Понятно</button>
        </div>
    </div>
</div>
