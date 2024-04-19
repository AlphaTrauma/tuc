@extends('layouts.dashboard')

@section('content')


    <div class="uk-form-horizontal">
        <h2>Список групп для обучения на стенде "Высота"</h2>
        @include('blocks.errors')
        <div class="uk-margin">
            <label class="uk-form-label" for="list">Список</label>
            <div class="uk-form-controls">
                <ul class="uk-list uk-list-divider">
                    @forelse($leads_groups as $group)
                        <li>
                            {{ $group->course_date->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }} - {{ $group->course_date->addDays(1)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                            <a href="{{ route('leads_group.remove', $group) }}" class="uk-link uk-text-danger"><span uk-icon="close"></span></a>
                        </li>
                    @empty
                        <li>Группы не добавлены</li>
                    @endforelse
                    <li>
                        <form action="{{ route('leads_group.add') }}" method="POST">
                            @csrf
                            <div  class="uk-flex uk-width-large">
                                <input required class="uk-input" name="course_date" id="course_date" type="date"  value="">
                                <input type="submit" class="uk-button uk-button-success" value="Добавить">
                            </div>

                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <hr>
@endsection
