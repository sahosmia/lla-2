<main class="tb-main am-dispute-system am-courses-system am-training-admin">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4>{{ __('trainingcalendar::trainingcalendar.all_trainings') }} ({{ $trainings->total() }})</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform" onsubmit="event.preventDefault();">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select class="form-control am-select2" wire:model.live="status">
                                            <option value="">{{ __('trainingcalendar::trainingcalendar.all_status') }}</option>
                                            <option value="published">{{ __('trainingcalendar::trainingcalendar.published') }}</option>
                                            <option value="draft">{{ __('trainingcalendar::trainingcalendar.draft') }}</option>
                                            <option value="cancelled">{{ __('trainingcalendar::trainingcalendar.cancelled') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.400ms="keyword"
                                        autocomplete="off" placeholder="{{ __('general.search') }}...">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="cr-stats-arae mb-4">
                <div class="cr-stat-card">
                    <div class="cr-contentbox">
                        <span>{{ $counts['total'] }}</span>
                        <p>{{ __('trainingcalendar::trainingcalendar.total_trainings') }}</p>
                    </div>
                    <span class="cr-iconbox blue">
                        <i class="icon-book"></i>
                    </span>
                </div>
                <div class="cr-stat-card">
                    <div class="cr-contentbox">
                        <span>{{ $counts['published'] }}</span>
                        <p>{{ __('trainingcalendar::trainingcalendar.published') }}</p>
                    </div>
                    <span class="cr-iconbox green">
                        <i class="icon-check-circle"></i>
                    </span>
                </div>
                <div class="cr-stat-card">
                    <div class="cr-contentbox">
                        <span>{{ $counts['draft'] }}</span>
                        <p>{{ __('trainingcalendar::trainingcalendar.draft') }}</p>
                    </div>
                    <span class="cr-iconbox red">
                        <i class="icon-file-text"></i>
                    </span>
                </div>
                <div class="cr-stat-card">
                    <div class="cr-contentbox">
                        <span>{{ $counts['cancelled'] }}</span>
                        <p>{{ __('trainingcalendar::trainingcalendar.cancelled') }}</p>
                    </div>
                    <span class="cr-iconbox yellow">
                        <i class="icon-x-circle"></i>
                    </span>
                </div>
            </div>

            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if($trainings->isNotEmpty())
                        <table class="tb-table">
                            <thead>
                                <tr>
                                    <th>{{ __('trainingcalendar::trainingcalendar.id') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.title') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.tutor') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.type') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.event_datetime') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.status') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trainings as $training)
                                    <tr>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.id') }}">
                                            <span>{{ $training->id }}</span>
                                        </td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.title') }}">
                                            <span>{{ $training->title }}</span>
                                        </td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.tutor') }}">
                                            <div class="am-instructor-column">
                                                <span>{{ $training->tutor?->profile?->full_name }}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.type') }}">
                                            <span>{{ ucfirst($training->type) }}</span>
                                        </td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.event_datetime') }}">
                                            <span>{{ $training->event_datetime?->format('M d, Y') }}</span>
                                        </td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.status') }}">
                                            <div class="am-status-tag">
                                                @php
                                                    $tagClass = match ($training->status) {
                                                        'published' => 'tk-active',
                                                        'draft' => 'tk-disabled',
                                                        'cancelled' => 'tk-disabled',
                                                        default => 'tk-disabled',
                                                    };
                                                @endphp
                                                <em class="tk-project-tag {{ $tagClass }}">{{ ucfirst($training->status) }}</em>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.actions') }}">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text">{{ __('courses::courses.view_details') }}</span>
                                                        <a href="{{ route('trainingcalendar.detail', $training->slug) }}" target="_blank">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text">{{ __('general.delete') }}</span>
                                                        <a href="javascript:void(0);" @click="$wire.dispatch('showConfirm', { id : {{ $training->id }}, action : 'delete-training' })" class="tb-delete">
                                                            <i class="icon-trash-2"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $trainings->links('pagination.custom') }}
                        </div>
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
@endpush
