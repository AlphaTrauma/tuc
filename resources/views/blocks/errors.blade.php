@if(Session::has('message'))
    <div class="uk-alert-success uk-margin-small-bottom" uk-alert>
        <p>{{ Session::get('message') }}</p>
    </div>
@endif
@if(Session::has('error'))
    <div class="uk-alert-danger uk-margin-small-bottom" uk-alert>
        <p>{{ Session::get('error') }}</p>
    </div>
@endif
@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="uk-alert-danger uk-margin-small-bottom" uk-alert>
            <p>{{ $error }}</p>
        </div>
    @endforeach
@endif
