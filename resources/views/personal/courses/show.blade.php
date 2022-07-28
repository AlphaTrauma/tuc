@extends('layouts.personal')

@section('content')
    <div class="uk-card uk-card-default uk-card-body">
        <h1 class="uk-card-title">{{ $user_course->course->title }} ({{ $user_course->course->length }}
            часов)
        </h1>
        @include('blocks.errors')
        @foreach($user_course->user_blocks as $user_block)
            <div @if($user_block->status) style="opacity: 0.5" @endif>
                <h4>
                    @if($user_block->status)
                        <span uk-tooltip="Завершите предыдущий блок, чтобы получить доступ" class="uk-text-danger" uk-icon="lock"></span>
                    @endif
                    {{ $user_block->block->title }}
                </h4>
                <ul class="uk-list uk-list-divider uk-margin-left">
                    @foreach($user_block->user_materials as $user_material)
                        <li>
                            @if($user_block->status)
                                <span uk-tooltip="Завершите предыдущий модуль, чтобы получить доступ к материалу" class="uk-text-danger" uk-icon="lock"></span>
                            @elseif($user_material->status) <span uk-tooltip="Материал просмотрен" class="uk-text-success" uk-icon="check"></span>
                            @else <span uk-icon="unlock" class="uk-text-success" uk-tooltip="Материал доступен для ознакомления"></span>
                            @endif
                            <span>{{ $user_material->ordering }}. {{ isset($user_material->material->title) ? $user_material->material->title : '' }}</span>
                            @if(!$user_block->status)<a href="{{ route('material.show', $user_material->id) }}">открыть</a>@endif
                        </li>
                    @endforeach
                    @if($user_block->block->test)
                        <li>
                            @if($user_block->status)
                                <span uk-tooltip="Завершите предыдущий модуль, чтобы получить доступ к тестированию" class="uk-text-danger" uk-icon="lock"></span>
                            @elseif($user_block->user_test->done_at)
                                <span uk-tooltip="Тест успешно пройден" class="uk-text-success" uk-icon="check"></span>
                            @endif
                            <span><b>{{ $user_block->user_materials->count() + 1 }}. {{ $user_block->block->test->title }}</b></span>
                                @if($user_block->user_test->done_at)<span class="uk-text-muted">(завершён {{ $user_block->user_test->done_at->format('d.m.Y') }})</span>@endif
                            @if(!$user_block->status)<a href="{{ route('personal.test', ['id' => $user_block->block->test->id, 'block_id' => $user_block->id]) }}">
                                    пройти
                                </a>
                            @endif
                        </li>
                    @endif
                </ul>
                <progress class="uk-progress"
                          uk-tooltip="Прогресс освоения теоретических материалов модуля {{ $user_block->user_materials->where('status', 1)->count() }}
                              из {{ $user_block->user_materials->count()  }}"
                          value="{{ $user_block->user_materials->where('status', 1)->count()  }}"
                          max="{{ $user_block->user_materials->count() }}">
                </progress>
            </div>
            <hr>
        @endforeach
        @if($user_course->status)
            <p><b class="uk-text-success">Курс завершён, свяжитесь с нашим менеджером для получения сертификата</b></p>
        @else
            <a href="{{ route('material.show', $user_course->user_blocks->first()->user_materials->first()->id) }}"
               class="uk-button uk-button-success">Начать</a>
        @endif
    </div>
    </div>

@endsection
