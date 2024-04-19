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
                    <input type="text" value="" name="fax" id="fax" class="uk-hidden">
                    <input type="text" value="" name="theme" id="theme" class="uk-hidden">
                    <input type="text" value="" name="contact" class="uk-hidden">
                </div>
                <div class="uk-margin-small">
                    <textarea placeholder="Комментарий" id="" cols="30" rows="10" class="uk-textarea" name="comment"></textarea>
                </div>
                <input type="hidden" name="page" value="{{ request()->url() }}">
                <input type="hidden" name="course" value="">
                <div class="uk-margin-small">
                    <input type="submit" value="Отправить" class="uk-button uk-button-primary uk-width-1-1">
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-height" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Оставить заявку на очное обучение безопасному проведению работ на высоте</h2>
        </div>
        <div class="uk-modal-body">
            <form action="{{ route('lead.store') }}" method="POST" class="uk-form">
                @csrf
                <div class="uk-margin-small">
                    <input type="text" placeholder="Телефон (обязательно)" name="phone" required class="uk-input">
                </div>
                <div class="uk-margin-small">

                    <select name="leads_groups_id" id="course_group" class="uk-select">
                        <option value="">Выберите желаемые даты обучения</option>
                        @foreach($leads_groups as $group)
                            <option value="{{ $group->id }}">{{ $group->course_date->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }} -
                                {{ $group->course_date->addDays(1)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="uk-margin-small">
                    <div uk-grid class="uk-grid-small uk-child-width-1-2@s">
                        <div>
                            <input type="text" placeholder="ФИО" name="name" class="uk-input">
                        </div>
                        <div>
                            <input type="text" placeholder="E-Mail" name="email" class="uk-input">
                        </div>
                    </div>

                </div>
                <div class="uk-margin-small">
                    <input type="text" value="" name="fax" id="fax" class="uk-hidden">
                    <input type="text" value="" name="theme" id="theme" class="uk-hidden">
                    <input type="text" value="" name="contact" class="uk-hidden">
                </div>
                <div class="uk-margin-small">
                    <textarea placeholder="Комментарий" id="" cols="30" rows="10" class="uk-textarea" name="comment"></textarea>
                </div>
                <input type="hidden" name="page" value="{{ request()->url() }}">
                <input type="hidden" name="course" value="height">
                <div class="uk-margin-small">
                    <input type="submit" value="Отправить" class="uk-button uk-button-primary uk-width-1-1">
                </div>
            </form>
        </div>
    </div>
</div>
