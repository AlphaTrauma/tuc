<form method="POST" action="{{ route('group.update', $group) }}">
    @csrf
    <div uk-grid class="uk-form-horizontal">
        <div class="uk-width-1-2">
            <div>
                <label class="uk-form-label" for="">Номер группы</label>
                <div class="uk-form-controls">
                    <input class="uk-input"  name="number" value="{{ $group->number }}" placeholder="Номер группы" type="text">
                </div>
            </div>


        </div>
        <div class="uk-width-1-2">
            <div>
                <label class="uk-form-label" for="">Обучение, с</label>
                <div class="uk-form-controls">
                    <input class="uk-input"  name="start_date" value="{{ $group->start_date ? $group->start_date->format('Y-m-d') : '' }}" type="date">
                </div>
            </div>

        </div>
        <div class="uk-width-1-2">
            <div>
                <label class="uk-form-label" for="">Обучение, по</label>
                <div class="uk-form-controls">
                    <input class="uk-input"  name="end_date" value="{{ $group->end_date ? $group->end_date->format('Y-m-d') : '' }}" type="date">
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div>
                <label class="uk-form-label" for="">Номер договора</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="contract" value="{{ $group->contract }}" placeholder="Номер договора" type="text">
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div>
                <label class="uk-form-label" for="">№ протокола</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="protocol" value="{{ $group->protocol }}" placeholder="Протокол" type="text">
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div>
                <label class="uk-form-label" for="">Выбранный курс</label>
                <div class="uk-form-controls">
                    <select class="uk-select" name="course_id">
                        <option value="">Выбрать</option>
                        @foreach($user_courses[$group->id] as $course)
                            <option @if($course->id === $group->course_id) selected @endif value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-flex">
        <div>
            <h4 class="uk-text-center">Протокол, 1 лист</h4>
            <div class="uk-form-horizontal uk-padding-small">
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="">Председатель комиссии</label>
                    <div class="uk-form-controls uk-flex">
                        <select class="uk-select" name="chairman_pos">
                            <option value="">Выбрать</option>
                            @foreach($positions as $position)
                                <option @if($position->name === $group->chairman_pos) selected @endif value="{{ $position->name }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <select class="uk-select" name="chairman">
                            <option value="">Выбрать</option>
                            @foreach($personnel as $person)
                                <option @if($person->name === $group->chairman) selected @endif value="{{ $person->name }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="">Член комиссии 1</label>
                    <div class="uk-form-controls uk-flex">
                        <select class="uk-select" name="member1_pos">
                            <option value="">Выбрать</option>
                            @foreach($positions as $position)
                                <option @if($position->name === $group->member1_pos) selected @endif value="{{ $position->name }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <select class="uk-select" name="member1">
                            <option value="">Выбрать</option>
                            @foreach($personnel as $person)
                                <option @if($person->name === $group->member1) selected @endif value="{{ $person->name }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="">Член комиссии 2</label>
                    <div class="uk-form-controls uk-flex">
                        <select class="uk-select" name="member2_pos">
                            <option value="">Выбрать</option>
                            @foreach($positions as $position)
                                <option @if($position->name === $group->member2_pos) selected @endif value="{{ $position->name }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <select class="uk-select" name="member2">
                            <option value="">Выбрать</option>
                            @foreach($personnel as $person)
                                <option @if($person->name === $group->member2) selected @endif value="{{ $person->name }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label" for=""><b>Куратор группы</b></label>
                    <div class="uk-form-controls uk-flex">
                        <select class="uk-select" name="secretary2_pos">
                            <option value="">Выбрать</option>
                            @foreach($positions as $position)
                                <option @if($position->name === $group->secretary2_pos) selected @endif value="{{ $position->name }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <select class="uk-select" name="secretary2">
                            <option value="">Выбрать</option>
                            @foreach($personnel as $person)
                                <option @if($person->name === $group->secretary2) selected @endif value="{{ $person->name }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h4 class="uk-text-center">Протокол, 2 лист</h4>
            <div class="uk-form-horizontal uk-padding-small">
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="">Председатель комиссии</label>
                    <div class="uk-form-controls uk-flex">
                        <select class="uk-select" name="chairman2_pos">
                            <option value="">Выбрать</option>
                            @foreach($positions as $position)
                                <option @if($position->name === $group->chairman2_pos) selected @endif value="{{ $position->name }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <select class="uk-select" name="chairman2">
                            <option value="">Выбрать</option>
                            @foreach($personnel as $person)
                                <option @if($person->name === $group->chairman2) selected @endif value="{{ $person->name }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="">Член комиссии 1</label>
                    <div class="uk-form-controls uk-flex">
                        <select class="uk-select" name="member3_pos">
                            <option value="">Выбрать</option>
                            @foreach($positions as $position)
                                <option @if($position->name === $group->member3_pos) selected @endif value="{{ $position->name }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <select class="uk-select" name="member3">
                            <option value="">Выбрать</option>
                            @foreach($personnel as $person)
                                <option @if($person->name === $group->member3) selected @endif value="{{ $person->name }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="">Член комиссии 2</label>
                    <div class="uk-form-controls uk-flex">
                        <select class="uk-select" name="member4_pos">
                            <option value="">Выбрать</option>
                            @foreach($positions as $position)
                                <option @if($position->name === $group->member4_pos) selected @endif value="{{ $position->name }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <select class="uk-select" name="member4">
                            <option value="">Выбрать</option>
                            @foreach($personnel as $person)
                                <option @if($person->name === $group->member4) selected @endif value="{{ $person->name }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="">Секретарь</label>
                    <div class="uk-form-controls uk-flex">
                        <select class="uk-select" name="secretary_pos">
                            <option value="">Выбрать</option>
                            @foreach($positions as $position)
                                <option @if($position->name === $group->secretary_pos) selected @endif value="{{ $position->name }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <select class="uk-select" name="secretary">
                            <option value="">Выбрать</option>
                            @foreach($personnel as $person)
                                <option @if($person->name === $group->secretary) selected @endif value="{{ $person->name }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="uk-width-1-1">
        <input class="uk-button uk-button-primary uk-width-1-1" value="Изменить" type="submit">
    </div>
</form>
