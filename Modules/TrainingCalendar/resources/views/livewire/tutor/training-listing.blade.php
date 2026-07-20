<div class="am-quizlist am-training-list" wire:init="loadData">
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ __('trainingcalendar::trainingcalendar.training_list') }}</h2>
            <p>{{ __('trainingcalendar::trainingcalendar.manage_your_trainings') }}</p>
        </div>
        <div class="am-_btn_wrap">
            <a href="{{ route('trainingcalendar.tutor.create') }}" class="am-btn">
                {{ __('trainingcalendar::trainingcalendar.create_training') }}
                <i class="am-icon-plus-02"></i>
            </a>
        </div>
    </div>

    <div class="cr-stats-arae">
        <div class="cr-stat-card">
            <div class="cr-contentbox">
                <span>{{ $counts['total'] }}</span>
                <p>{{ __('trainingcalendar::trainingcalendar.total_trainings') }}</p>
            </div>
            <span class="cr-iconbox blue">
                <i class="am-icon-book-1"></i>
            </span>
        </div>
        <div class="cr-stat-card">
            <div class="cr-contentbox">
                <span>{{ $counts['published'] }}</span>
                <p>{{ __('trainingcalendar::trainingcalendar.published') }}</p>
            </div>
            <span class="cr-iconbox green">
                <i class="am-icon-check-circle03"></i>
            </span>
        </div>
        <div class="cr-stat-card">
            <div class="cr-contentbox">
                <span>{{ $counts['draft'] }}</span>
                <p>{{ __('trainingcalendar::trainingcalendar.draft') }}</p>
            </div>
            <span class="cr-iconbox red">
                <i class="am-icon-file-02"></i>
            </span>
        </div>
        <div class="cr-stat-card">
            <div class="cr-contentbox">
                <span>{{ $counts['cancelled'] }}</span>
                <p>{{ __('trainingcalendar::trainingcalendar.cancelled') }}</p>
            </div>
            <span class="cr-iconbox yellow">
                <i class="am-icon-multiply-01"></i>
            </span>
        </div>
    </div>

    <div class="am-quizsearuch_header">
        <div class="am-quizlist_search">
            <input type="text" wire:model.live.debounce.400ms="keyword" class="form-control"
                placeholder="{{ __('general.search') }}">
            <i class="am-icon-search-02"></i>
        </div>
        <div class="am-slots_wrap">
            <ul class="am-category-slots">
                <li>
                    <button wire:click="$set('status', '')" class="{{ $status === '' ? 'active' : '' }}">
                        {{ __('trainingcalendar::trainingcalendar.all') }}
                    </button>
                </li>
                <li>
                    <button wire:click="$set('status', 'published')"
                        class="{{ $status === 'published' ? 'active' : '' }}">
                        {{ __('trainingcalendar::trainingcalendar.published') }}
                    </button>
                </li>
                <li>
                    <button wire:click="$set('status', 'draft')" class="{{ $status === 'draft' ? 'active' : '' }}">
                        {{ __('trainingcalendar::trainingcalendar.draft') }}
                    </button>
                </li>
                <li>
                    <button wire:click="$set('status', 'cancelled')"
                        class="{{ $status === 'cancelled' ? 'active' : '' }}">
                        {{ __('trainingcalendar::trainingcalendar.cancelled') }}
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="am-table-area">
        @if (!$isLoading)
            @if ($trainings->isNotEmpty())
                <div class="cr-allcourses_list">
                    @foreach ($trainings as $training)
                        <div class="cr-card">
                            {{-- <figure class="cr-image-wrapper">
                                <img src="{{ asset('modules/trainingcalendar/images/training-placeholder.png') }}"
                                    alt="{{ $training->title }}" class="cr-background-image"
                                    onerror="this.src='{{ asset('demo-content/placeholders/placeholder.png') }}'">
                                <figcaption>
                                    <span class="am-quizstatus am-quizstatus_published">
                                        {{ ucfirst($training->type) }}
                                    </span>
                                </figcaption>
                            </figure> --}}
                            <div class="cr-course-card">
                                <div class="cr-course-header">
                                    <a class="cr-course-title"
                                        href="{{ route('trainingcalendar.tutor.edit', $training->id) }}">{{ $training->title }}</a>
                                    <div class="cr-course-category">
                                        <span>
                                            <i class="am-icon-calender-day"></i>
                                            {{ $training->event_datetime?->format('M d, Y • h:i A') }}
                                        </span>
                                    </div>
                                    <div class="cr-course-category mt-2">
                                        <span>
                                            <i class="am-icon-user-01"></i>
                                            {{ $training->paid_registrations_count }} /
                                            {{ $training->max_seats ?? '∞' }}
                                            {{ __('trainingcalendar::trainingcalendar.registrations') }}
                                        </span>
                                    </div>
                                    <div class="cr-course-category mt-2">
                                        <span class="am-quizstatus am-quizstatus_published">
                                            {{ ucfirst($training->type) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="cr-status-wrap mt-3">
                                    <div class="cr-course-category">
                                        <span class="cr-price"
                                            style="font-size: 15px; font-weight: 700; color: #272727;">
                                            {{ formatAmount($training->price) }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        @php
                                            $dotColor = match ($training->status) {
                                                'published' => '#008000',
                                                'draft' => '#ff9f43',
                                                'cancelled' => '#ff4d4f',
                                                default => '#585858',
                                            };
                                            $dotClass = match ($training->status) {
                                                'published' => 'active',
                                                'draft' => '',
                                                'cancelled' => 'cancelled',
                                                default => '',
                                            };
                                        @endphp
                                        <span class="cr-status">
                                            <span style="background-color: {{ $dotColor }};"
                                                class="cr-dot {{ $dotClass }}"></span>
                                            {{ ucfirst($training->status) }}
                                        </span>
                                        <div class="am-itemdropdown">
                                            <a href="javascript:void(0);" id="am-itemdropdown" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="am-icon-ellipsis-vertical-02"></i>
                                            </a>
                                            <ul class="am-itemdropdown_list dropdown-menu"
                                                aria-labelledby="dropdownMenuLink">
                                                <li>
                                                    <a
                                                        href="{{ route('trainingcalendar.tutor.edit', $training->id) }}">
                                                        <i class="am-icon-pencil-02"></i>
                                                        {{ __('trainingcalendar::trainingcalendar.update') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('trainingcalendar.tutor.registrations', $training->id) }}">
                                                        <i class="am-icon-user-01"></i>
                                                        {{ __('trainingcalendar::trainingcalendar.view_registrations') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('trainingcalendar.tutor.send-notice', $training->id) }}">
                                                        <i class="am-icon-email"></i>
                                                        {{ __('trainingcalendar::trainingcalendar.send_notice') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);"
                                                        wire:click="deleteTraining({{ $training->id }})"
                                                        wire:confirm="{{ __('trainingcalendar::trainingcalendar.confirm_delete') }}"
                                                        class="am-del-btn">
                                                        <i class="am-icon-trash-02"></i>
                                                        {{ __('trainingcalendar::trainingcalendar.delete') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="am-pagination am-quiz-pagination mt-4">
                    {{ $trainings->links('pagination.custom') }}
                </div>
            @else
                <div class="am-emptyview">
                    <figure class="am-emptyview_img">
                        <img src="{{ asset('modules/quiz/images/quiz-list/empty.png') }}" alt="img description">
                    </figure>
                    <div class="am-emptyview_title">
                        <h3>{{ __('trainingcalendar::trainingcalendar.no_trainings') }}</h3>
                        <p>{{ __('trainingcalendar::trainingcalendar.no_trainings_found_desc') }}</p>
                    </div>
                </div>
            @endif
        @else
            <div class="cr-allcourses_list">
                @for ($i = 0; $i < 8; $i++)
                    <div class="cr-card cr-card-skeleton">
                        <div class="cr-image-wrapper" style="height: 180px; background: #eee;"></div>
                        <div class="cr-course-card">
                            <div class="cr-course-header">
                                <div style="width: 100%; height: 20px; background: #eee; margin-bottom: 10px;"></div>
                                <div style="width: 60%; height: 15px; background: #eee; margin-bottom: 10px;"></div>
                                <div style="width: 40%; height: 15px; background: #eee;"></div>
                            </div>
                            <div style="width: 100%; height: 30px; background: #eee; margin-top: 20px;"></div>
                        </div>
                    </div>
                @endfor
            </div>
        @endif
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    <style>
        .am-training-list .cr-stats-arae {
            margin-bottom: 30px;
        }

        .am-training-list .cr-image-wrapper img {
            object-fit: cover;
            height: 180px;
            width: 100%;
        }

        .am-training-list .am-quizstatus {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 2px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            background: #e6f9f1;
            color: #00b96b;
        }

        .am-training-list .cr-status-wrap {
            display: flex;

            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .cr-card ul li,
        .cr-card-skeleton ul li {
            font-size: 14px;
            margin-bottom: 8px;
            padding-left: 8px;
            position: relative;
        }

        .cr-card ul li::before,
        .cr-card-skeleton ul li::before {

            display: none
        }

        .cr-allcourses_list .cr-card .cr-course-card .cr-course-header .cr-course-category span,
        .cr-allcourses_list .cr-card-skeleton .cr-course-card .cr-course-header .cr-course-category span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
@endpush
