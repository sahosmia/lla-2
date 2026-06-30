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

            <div class="am-quizlist_wrap">
                @if($trainings->isNotEmpty())
                    <ul class="row gy-4 list-unstyled">
                        @foreach($trainings as $training)
                            <li class="col-xl-4 col-lg-6 col-md-6">
                                <div class="am-quizlist_item border rounded bg-white h-100 d-flex flex-column">
                                    <figure class="position-relative m-0">
                                        <img src="{{ asset('modules/trainingcalendar/images/training-placeholder.png') }}" class="w-100 rounded-top" style="height: 180px; object-fit: cover;" alt="training image" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                        <figcaption class="position-absolute top-0 end-0 p-2">
                                            @php
                                                $statusClass = match ($training->status) {
                                                    'draft' => 'am-quizstatus_draft',
                                                    'cancelled' => 'am-quizstatus_archived',
                                                    default => 'am-quizstatus_published',
                                                };
                                            @endphp
                                            <span class="am-quizstatus {{ $statusClass }}">
                                                {{ ucfirst($training->status) }}
                                            </span>
                                        </figcaption>
                                    </figure>
                                    <div class="am-quizlist_item_content p-3 flex-grow-1 d-flex flex-column">
                                        <div class="am-quizlist_coursename d-flex justify-content-between align-items-start mb-2">
                                            <div class="am-quizlist_coursetitle">
                                                <h3 class="m-0 h6 fw-bold">{{ $training->title }}</h3>
                                                <span class="text-muted small">{{ ucfirst($training->type) }}</span>
                                            </div>
                                            <div class="am-itemdropdown">
                                                <a href="javascript:void(0);" id="am-itemdropdown-{{ $training->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-more-vertical"></i>
                                                </a>
                                                <ul class="am-itemdropdown_list dropdown-menu dropdown-menu-end" aria-labelledby="am-itemdropdown-{{ $training->id }}">
                                                    <li>
                                                        <a href="{{ route('trainingcalendar.detail', $training->slug) }}" target="_blank" class="dropdown-item">
                                                            <i class="icon-eye me-2"></i>
                                                            {{ __('courses::courses.view_details') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" @click="$wire.dispatch('showConfirm', { id : {{ $training->id }}, action : 'delete-training' })" class="dropdown-item text-danger">
                                                            <i class="icon-trash-2 me-2"></i>
                                                            {{ __('general.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        @if($training->tutor?->profile)
                                            <div class="card-tutor-profile d-flex align-items-center mb-3">
                                                @if($training->tutor->profile->image)
                                                    <img src="{{ asset('storage/' . $training->tutor->profile->image) }}" alt="Tutor" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle me-2 bg-indigo text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 12px; font-weight: bold;">
                                                        {{ substr($training->tutor->profile->first_name ?? 'T', 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="tutor-info-text">
                                                    <span class="small fw-bold">{{ $training->tutor->profile->full_name }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <ul class="am-quizlist_item_footer list-unstyled mt-auto pt-3 border-top d-flex flex-wrap gap-3">
                                            <li class="d-flex align-items-center gap-1 small text-muted">
                                                <i class="icon-calendar"></i>
                                                {{ $training->event_datetime?->format('M d, Y') }}
                                            </li>
                                            <li class="d-flex align-items-center gap-1 small text-muted">
                                                <i class="icon-users"></i>
                                                {{ $training->paid_registrations_count }} / {{ $training->max_seats ?? '∞' }}
                                            </li>
                                            <li class="d-flex align-items-center gap-1 small text-muted ms-auto fw-bold text-dark">
                                                {{ formatAmount($training->price) }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4">
                        {{ $trainings->links('pagination.custom') }}
                    </div>
                @else
                    <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                @endif
            </div>
        </div>
    </div>
</main>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    <style>
        .am-training-admin .am-quizstatus {
            padding: 2px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        .am-training-admin .am-quizstatus_published { background: #e6f9f1; color: #00b96b; }
        .am-training-admin .am-quizstatus_draft { background: #fef4e6; color: #ff9f43; }
        .am-training-admin .am-quizstatus_archived { background: #feebeb; color: #ff4d4f; }
    </style>
@endpush
