@extends('layouts.personal')

@section('content')
    <table class="uk-table uk-table-striped">
        @forelse($items as $user_course)
            <div class="uk-card uk-card-default uk-card-body">
                <h2 class="uk-card-title">{{ $user_course->course->title }} ({{ $user_course->course->length }} часов)</h2>
                <div>
                    @foreach($user_course->user_blocks as $user_block)
                        <div>
                            <h4>{{ $user_block->block->title }}</h4>
                            <ul class="uk-list uk-list-divider uk-margin-left">
                            @foreach($user_block->user_materials as $user_material)
                                <li>
                                    @if($user_material->status) <span class="uk-text-success" uk-icon="check"></span>
                                    @else <span uk-icon="minus"></span>
                                    @endif
                                    <span>{{ $user_material->ordering }}. {{ $user_material->material->title }}</span>
                                    <a href="{{ route('material.show', $user_material->id) }}">открыть</a>
                                </li>
                            @endforeach
                            </ul>
                            <progress class="uk-progress" uk-tooltip="Прогресс освоения блока {{ $user_block->user_materials->where('status', 1)->count() }}
                                из {{ $user_block->user_materials->count() }}" value="{{ $user_block->user_materials->where('status', 1)->count() }}"
                                      max="{{ $user_block->user_materials->count() }}">
                            </progress>
                        </div>
                        <hr>
                    @endforeach
                </ul>
                <a href="" hidden class="uk-button uk-button-small uk-button-success uk-float-right">Приступить</a>

            </div>
        @empty
            <tr>
                <td>Курсы отсутствуют.</td>
                <td>
                    <a href="/all_directions" class="uk-button uk-button-small uk-button-success uk-float-right">Выбрать</a>
                </td>
            </tr>
        @endforelse
    </table>
@endsection
