@extends('layouts.dashboard')

@section('content')
    <h1>Страница контрагента {{ $item->name }}</h1>
    @include('blocks.errors')
    <upload-contractors :id="{{ $item->id }}">
        @csrf
    </upload-contractors>
    <div class="uk-card uk-card-default uk-margin-top">
        <div class="uk-card-body">
            <b>Памятка по таблице импорта</b>: документ excel с указанными далее столбцами. Список импортируемых пользователей должен начинаться со второй строки (в первой опционально заголовки), в нём не должно быть пустых строк.
            Список колонок: <b>A</b> — фамилия, <b>B</b> — имя, <b>A</b> — отчество, <b>D</b> — должность, <b>E</b> — дата рождения (тип данных ячейки "текстовый", не "дата"), <b>F</b> — СНИЛС, <b>G</b> — паспорт, <b>H</b> — моб. телефон, <b>I</b> — документ об образовании.
        </div>
    </div>

    @foreach($item->groups as $group)
        <div class="uk-card uk-card-default uk-margin-top">
            <div class="uk-card-header" >
                <div>
                    <h2 class="uk-card-title">
                        @if($group->number)
                            Группа {{ $group->number }}
                        @else
                            Группа от {{ $group->created_at->format('d.m.Y') }}
                        @endif

                    </h2>
                    <div class="uk-button-group uk-float-right">
                        <div class="uk-button uk-button-success" type="button" uk-toggle="target: #form-{{ $group->id }}; animation: uk-animation-fade">
                            Настройки группы
                        </div>
                        <a href="#add-course-{{ $group->id }}" uk-toggle class="uk-button uk-button-default">Добавить курс</a>
                    </div>
                </div>
                @if($group->users->count() and $group->users->first()->latestCourse)
                    <small class="uk-text-success">({{ $group->users->first()->latestCourse->course->title }})</small>
                @else
                    <small class="uk-text-danger">(Курс не выбран)</small>
                @endif

            </div>
            <div hidden id="form-{{ $group->id }}" class="uk-card-body">

                <form method="POST" action="{{ route('group.update', $group) }}">
                    @csrf
                    <div uk-grid class="uk-form-horizontal">
                    <div class="uk-width-1-4">
                        <div>
                            <label class="uk-form-label" for="">Номер группы</label>
                            <div class="uk-form-controls">
                                <input class="uk-input"  name="number" value="{{ $group->number }}" placeholder="Номер группы" type="text">
                            </div>
                        </div>


                    </div>
                    <div class="uk-width-1-4">
                        <div>
                            <label class="uk-form-label" for="">Обучение, с</label>
                            <div class="uk-form-controls">
                                <input class="uk-input"  name="start_date" value="{{ $group->start_date ? $group->start_date->format('Y-m-d') : '' }}" type="date">
                            </div>
                        </div>

                    </div>
                    <div class="uk-width-1-4">
                        <div>
                            <label class="uk-form-label" for="">Обучение, по</label>
                            <div class="uk-form-controls">
                                <input class="uk-input"  name="end_date" value="{{ $group->end_date ? $group->end_date->format('Y-m-d') : '' }}" type="date">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-4">
                        <div>
                            <label class="uk-form-label" for="">Номер договора</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="contract" value="{{ $group->contract }}" placeholder="Номер договора" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-4">
                        <div>
                            <label class="uk-form-label" for="">№ протокола</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="protocol" value="{{ $group->protocol }}" placeholder="Протокол" type="text">
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
            </div>
            <div class="uk-card-body">
                <div class="uk-width-medium uk-float-right">
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'orders']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать приказы <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'statement']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать ведомость <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'protocol']) }}" class="uk-button uk-button-text uk-button-small  uk-margin-small">Скачать протоколы <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificates']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать удостоверения <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificatesPC']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать удостоверения ПК <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificatesPrint']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать удостоверения печать <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificatesWorker']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать свид. проф. раб. <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'certificatesWorker2']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать удост. проф. раб. <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'agreements']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать соглашения <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'po']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать реестр ПО <span uk-icon="download"></span></a>
                    <a href="{{ route('group.document', ['group' => $group, 'type' => 'dpo']) }}" class="uk-button uk-button-text uk-button-small uk-margin-small">Скачать реестр ДПО <span uk-icon="download"></span></a>

                </div>


                @php
                    $chunks = $group->users->chunk(10);
                @endphp
                <ul class="uk-list">
                    @foreach($chunks[0] as $user)
                        <li>
                            <a href="{{ route('user.show', $user->id) }}" class="uk-link uk-link-text">{{ $user->last_name }} @if($user->name){{ mb_substr($user->name, 0, 1) }}.@endif @if($user->patronymic){{ mb_substr($user->patronymic, 0, 1) }}.@endif</a>
                        </li>
                    @endforeach
                </ul>
                @if(count($chunks) > 1)

                    <ul hidden id="users-{{ $group->id }}" class="uk-list">
                        @foreach($chunks as $key => $chunk)
                            @if($key > 0)
                                @foreach($chunk as $user)
                                    <li>
                                        <a href="{{ route('user.show', $user->id) }}" class="uk-link uk-link-text">{{ $user->last_name }} @if($user->name){{ mb_substr($user->name, 0, 1) }}.@endif @if($user->patronymic){{ mb_substr($user->patronymic, 0, 1) }}.@endif</a>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                    <button class="uk-button uk-button-small uk-button-text uk-margin-small" type="button" uk-toggle="target: #users-{{ $group->id }}; animation: uk-animation-fade">
                        Показать/скрыть полный список
                    </button>
                @endif

            </div>
            <div class="uk-card-body">
                <upload-contractors :group="{{ $group->id }}" :id="{{ $item->id }}">
                    @csrf
                </upload-contractors>
            </div>
            <div id="add-course-{{ $group->id }}" class="uk-flex-top" uk-modal>
                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                    <h2 class="uk-modal-title">Открыть доступ к курсу</h2>
                    <form class="uk-form" enctype=multipart/form-data method="POST" action="{{ route('courses.addGroup') }}">
                        @csrf
                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                        <div class="uk-margin">
                            <select class="uk-select" name="course_id" id="course_id">
                                <option value="">Выберите курс</option>
                                @foreach($courses as $id => $name)
                                    <option value="{{ $id }}">{{ \Illuminate\Support\Str::limit($name, 60) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" class="uk-button uk-button-success uk-width-1-1" value="Открыть доступ">
                    </form>
                </div>
            </div>

        </div>
    @endforeach

@endsection
