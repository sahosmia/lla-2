<div class="cr-allcourses am-student-trainings" wire:init="loadData">
    <div class="cr-allcourses_title">
        <div>
            <h2>{{ __('trainingcalendar::trainingcalendar.my_trainings') }}</h2>
            <p>{{ __('trainingcalendar::trainingcalendar.track_your_registered_trainings') }}</p>
        </div>
    </div>

    <div class="cr-allcourses_list">
        @if($registrations->isNotEmpty())
            @foreach($registrations as $registration)
                @php $training = $registration->training; @endphp
                @if($training)
                    <div class="cr-card">
                        <figure class="cr-image-wrapper">
                            <img src="{{ asset('modules/trainingcalendar/images/training-placeholder.png') }}" alt="{{ $training->title }}" class="cr-background-image" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                            <figcaption>
                                <span class="am-quizstatus am-quizstatus_published">
                                    {{ ucfirst($training->type) }}
                                </span>
                            </figcaption>
                        </figure>
                        <div class="cr-course-card">
                            <div class="cr-course-header">
                                <div class="cr-instructor-info">
                                    <div class="cr-instructor-details">
                                        @if($training->tutor?->profile)
                                            <div class="cr-instructor-name">
                                                @if($training->tutor->profile->image)
                                                    <img src="{{ asset('storage/' . $training->tutor->profile->image) }}" alt="Tutor" class="cr-instructor-avatar">
                                                @else
                                                    <div class="cr-instructor-avatar bg-indigo text-white d-flex align-items-center justify-content-center" style="font-size: 10px; font-weight: bold;">
                                                        {{ substr($training->tutor->profile->first_name ?? 'T', 0, 1) }}
                                                    </div>
                                                @endif
                                                {{ $training->tutor->profile->full_name }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <a class="cr-course-title" href="{{ route('trainingcalendar.student.training-detail', $registration->id) }}">{{ $training->title }}</a>
                                <div class="cr-course-category">
                                    <span>
                                        <i class="am-icon-calender-day"></i>
                                        {{ $training->event_datetime?->format('M d, Y • h:i A') }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('trainingcalendar.student.training-detail', $registration->id) }}" class="am-btn w-100 justify-content-center">
                                    {{ __('general.view_details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="cr-courses-emptycase">
                <div class="cr-no-record-container">
                    <figure>
                        <img src="{{ asset('modules/courses/images/empty-view.png') }}" alt="empty-view">
                    </figure>
                    <h6>{{ __('trainingcalendar::trainingcalendar.no_registrations_found') }}</h6>
                    <p>{{ __('trainingcalendar::trainingcalendar.no_registrations_found_desc') }}</p>
                </div>
            </div>
        @endif
    </div>

    @if($registrations->isNotEmpty())
        <div class="cr-pagination mt-4">
            {{ $registrations->links('pagination.custom') }}
        </div>
    @endif
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    <style>
        .am-student-trainings .cr-image-wrapper img {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }
        .am-student-trainings .am-quizstatus {
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
    </style>
@endpush
