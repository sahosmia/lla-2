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
            <input type="text" wire:model.live.debounce.400ms="keyword" class="form-control" placeholder="{{ __('general.search') }}">
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
                    <button wire:click="$set('status', 'published')" class="{{ $status === 'published' ? 'active' : '' }}">
                        {{ __('trainingcalendar::trainingcalendar.published') }}
                    </button>
                </li>
                <li>
                    <button wire:click="$set('status', 'draft')" class="{{ $status === 'draft' ? 'active' : '' }}">
                        {{ __('trainingcalendar::trainingcalendar.draft') }}
                    </button>
                </li>
                <li>
                    <button wire:click="$set('status', 'cancelled')" class="{{ $status === 'cancelled' ? 'active' : '' }}">
                        {{ __('trainingcalendar::trainingcalendar.cancelled') }}
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="am-quizlist_wrap">
        @if($trainings->isNotEmpty())
            <ul>
                @foreach($trainings as $training)
                    <li>
                        <div class="am-quizlist_item">
                            <figure>
                                <img src="{{ asset('modules/trainingcalendar/images/training-placeholder.png') }}" alt="training image" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                <figcaption>
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
                            <div class="am-quizlist_item_content">
                                <div class="am-quizlist_coursename">
                                    <div class="am-quizlist_coursetitle">
                                        <h3>{{ $training->title }}</h3>
                                        <span>{{ ucfirst($training->type) }}</span>
                                    </div>
                                    <div class="am-itemdropdown">
                                        <a href="javascript:void(0);" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="am-icon-ellipsis-vertical-02"></i>
                                        </a>
                                        <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li>
                                                <a href="{{ route('trainingcalendar.tutor.edit', $training->id) }}">
                                                    <i class="am-icon-pencil-02"></i>
                                                    {{ __('trainingcalendar::trainingcalendar.update') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('trainingcalendar.tutor.registrations', $training->id) }}">
                                                    <i class="am-icon-user-01"></i>
                                                    {{ __('trainingcalendar::trainingcalendar.view_registrations') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('trainingcalendar.tutor.send-notice', $training->id) }}">
                                                    <i class="am-icon-email"></i>
                                                    {{ __('trainingcalendar::trainingcalendar.send_notice') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" wire:click="deleteTraining({{ $training->id }})" wire:confirm="{{ __('trainingcalendar::trainingcalendar.confirm_delete') }}" class="am-del-btn">
                                                    <i class="am-icon-trash-02"></i>
                                                    {{ __('trainingcalendar::trainingcalendar.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="am-quizlist_item_footer">
                                    <li>
                                       <span>
                                            <i class="am-icon-calender-day"></i>
                                            {{__('trainingcalendar::trainingcalendar.event_datetime')}}
                                        </span> 
                                        <em>{{ $training->event_datetime?->format('M d, Y • h:i A') }}</em>
                                    </li>
                                    <li>
                                       <span>
                                            <i class="am-icon-user-01"></i>
                                            {{__('trainingcalendar::trainingcalendar.registered_count')}}
                                        </span> 
                                        <em>{{ $training->paid_registrations_count }} / {{ $training->max_seats ?? '∞' }}</em>
                                    </li>
                                    <li>
                                       <span>
                                            <i class="am-icon-layer-01"></i>
                                            {{__('trainingcalendar::trainingcalendar.price')}}
                                        </span> 
                                        <em>{{ formatAmount($training->price) }}</em>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="am-pagination am-quiz-pagination">
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
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    <style>
        .am-training-list .cr-stats-arae {
            margin-bottom: 30px;
        }
        .am-training-list .am-quizlist_item figure img {
            object-fit: cover;
        }
    </style>
@endpush
