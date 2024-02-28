<div id="register-user" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <h2 class="uk-modal-title">Зарегистрировать пользователя</h2>
        <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('users.add') }}">
            @csrf
            <div class="uk-margin">
                <input class="uk-input" type="text" name="email" placeholder="E-mail (необязательно)">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="name" required placeholder="Имя (обязательно)">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="patronymic" placeholder="Отчество">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="last_name" required placeholder="Фамилия (обязательно)">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="phone" placeholder="Телефон">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="organization" placeholder="Организация">
            </div>

            <input type="submit" class="uk-button uk-button-secondary uk-width-1-1" value="Зарегистрировать">
        </form>
    </div>
</div>
