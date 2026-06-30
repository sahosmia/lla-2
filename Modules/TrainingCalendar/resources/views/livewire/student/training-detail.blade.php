<div class="am-quiz-detail am-training-detail">
    <div class="am-quiz-detail_box">
        <div class="am-quiz-detail_content">
            <div class="am-quiz-detail_info">
                <figure>
                    @if($registration->training?->tutor?->profile?->image)
                        <img src="{{ asset('storage/' . $registration->training->tutor->profile->image) }}" alt="{{ $registration->training->tutor->profile->full_name }}" />
                    @else
                        <div class="cr-instructor-avatar bg-indigo text-white d-flex align-items-center justify-content-center" style="width: 160px; height: 160px; border-radius: 50%; font-size: 40px; font-weight: bold;">
                            {{ substr($registration->training?->tutor?->profile?->first_name ?? 'T', 0, 1) }}
                        </div>
                    @endif
                </figure>
                <h6>
                    {{ $registration->training?->tutor?->profile?->full_name }}
                    <span>{{ __('trainingcalendar::trainingcalendar.tutor') }}</span>
                </h6>
            </div>
            <div class="am-quiz-detail_description">
                @if($registration->training?->title)
                    <h3>{{ $registration->training->title }}</h3>
                @endif
                <div class="am-course-stats">
                    <div class="am-stat-item">
                        <div class="am-stat-icon-wrapper">
                            <i class="am-icon-calender-day"></i>
                        </div>
                        <div class="am-stat-content">
                            <span class="am-stat-label">{{ __('trainingcalendar::trainingcalendar.event_datetime') }}</span>
                            <span class="am-stat-value">{{ $registration->training?->event_datetime?->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                    <div class="am-stat-item">
                        <div class="am-stat-icon-wrapper">
                            <i class="am-icon-layer-01"></i>
                        </div>
                        <div class="am-stat-content">
                            <span class="am-stat-label">{{ __('trainingcalendar::trainingcalendar.type') }}</span>
                            <span class="am-stat-value">{{ ucfirst($registration->training?->type) }}</span>
                        </div>
                    </div>
                    @if($registration->training?->type === 'offline')
                    <div class="am-stat-item">
                        <div class="am-stat-icon-wrapper">
                            <i class="am-icon-map-03"></i>
                        </div>
                        <div class="am-stat-content">
                            <span class="am-stat-label">{{ __('trainingcalendar::trainingcalendar.venue') }}</span>
                            <span class="am-stat-value">{{ $registration->training->venue }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="am-training-content mt-4">
                    <h5>{{ __('trainingcalendar::trainingcalendar.description') }}</h5>
                    <p>{!! nl2br(e($registration->training?->description)) !!}</p>
                </div>

                <div class="am-instructions mt-4">
                    <h6>
                        <i class="am-icon-exclamation-01"></i>
                        {{ __('trainingcalendar::trainingcalendar.notices') }}
                    </h6>
                    @if($registration->training?->notices?->isNotEmpty())
                        <ul class="am-notice-list">
                            @foreach($registration->training->notices as $notice)
                                <li class="mb-4 p-3 border rounded bg-light">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0">{{ $notice->subject }}</h6>
                                        <small class="text-muted">{{ $notice->sent_at?->format('M d, Y h:i A') }}</small>
                                    </div>
                                    <p class="mb-2">{!! nl2br(e($notice->message)) !!}</p>
                                    <div class="am-notice-links d-flex flex-wrap gap-3">
                                        @if($notice->zoom_link)
                                            <a href="{{ $notice->zoom_link }}" target="_blank" class="am-btn am-btn-sm am-btn-light">
                                                <i class="am-icon-video"></i> Zoom
                                            </a>
                                        @endif
                                        @if($notice->meet_link)
                                            <a href="{{ $notice->meet_link }}" target="_blank" class="am-btn am-btn-sm am-btn-light">
                                                <i class="am-icon-video"></i> Google Meet
                                            </a>
                                        @endif
                                        @if($notice->location)
                                            <span class="small text-muted"><i class="am-icon-map-03"></i> {{ $notice->location }}</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">{{ __('trainingcalendar::trainingcalendar.no_notices_found') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="{{ asset('modules/quiz/css/main.css') }}" rel="stylesheet">
    <style>
        .am-training-detail .am-quiz-detail_box {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #eee;
        }
        .am-notice-list {
            list-style: none;
            padding: 0;
        }
        .am-notice-list li {
            border-left: 4px solid #4f46e5 !important;
        }
    </style>
@endpush
