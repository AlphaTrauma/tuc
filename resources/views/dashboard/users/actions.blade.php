<div class="uk-padding-small uk-padding-remove-horizontal uk-flex">
    <a href="#register-user" class="uk-button uk-button-success" uk-toggle>Зарегистрировать</a>
    @include('dashboard.users.modal')
    <div class="uk-margin-left">
        <form action="" class="uk-form">
            <div class="uk-inline">
                <a class="uk-form-icon uk-form-icon-flip" href="#" uk-icon="icon: search"></a>
                <input class="uk-input" type="text" name="search" placeholder="Email или фамилия">
            </div>
        </form>
    </div>
</div>
