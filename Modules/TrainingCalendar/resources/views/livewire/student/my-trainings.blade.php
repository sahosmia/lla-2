<div class="am-quizlist am-student-trainings">
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ __('trainingcalendar::trainingcalendar.my_trainings') }}</h2>
            <p>{{ __('trainingcalendar::trainingcalendar.track_your_registered_trainings') }}</p>
        </div>
    </div>

    <div class="am-quizlist_wrap">
        @if($registrations->isNotEmpty())
            <ul>
                @foreach($registrations as $registration)
                    @php $training = $registration->training; @endphp
                    @if($training)
                        <li>
                            <div class="am-quizlist_item">
                                <figure>
                                    <img src="{{ asset('modules/trainingcalendar/images/training-placeholder.png') }}" alt="training image" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                    <figcaption>
                                        <span class="am-quizstatus am-quizstatus_published">
                                            {{ ucfirst($training->type) }}
                                        </span>
                                    </figcaption>
                                </figure>
                                <div class="am-quizlist_item_content">
                                    <div class="am-quizlist_coursename">
                                        <div class="am-quizlist_coursetitle">
                                            <h3>{{ $training->title }}</h3>
                                            @if($training->tutor?->profile)
                                                <div class="cr-instructor-details mt-1">
                                                    <div class="cr-instructor-name">
                                                        @if($training->tutor->profile->image)
                                                            <img src="{{ asset('storage/' . $training->tutor->profile->image) }}" alt="Tutor" class="cr-instructor-avatar" style="width: 24px; height: 24px; border-radius: 50%;">
                                                        @else
                                                            <div class="cr-instructor-avatar bg-indigo text-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; font-size: 10px; font-weight: bold;">
                                                                {{ substr($training->tutor->profile->first_name ?? 'T', 0, 1) }}
                                                            </div>
                                                        @endif
                                                        <span class="ms-1" style="font-size: 13px; color: #585858;">{{ $training->tutor->profile->full_name }}</span>
                                                    </div>
                                                </div>
                                            @endif
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
                                    </ul>
                                    <div class="mt-3">
                                        <a href="{{ route('trainingcalendar.student.training-detail', $registration->id) }}" class="am-btn w-100 justify-content-center">
                                            {{ __('general.view_details') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="am-pagination am-quiz-pagination">
                {{ $registrations->links('pagination.custom') }}
            </div>
        @else
            <div class="am-emptyview">
                <figure class="am-emptyview_img">
                    <img src="{{ asset('modules/quiz/images/quiz-list/empty.png') }}" alt="img description">
                </figure>
                <div class="am-emptyview_title">
                    <h3>{{ __('trainingcalendar::trainingcalendar.no_registrations_found') }}</h3>
                    <p>{{ __('trainingcalendar::trainingcalendar.no_registrations_found_desc') }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    <style>
        .am-student-trainings .am-quizlist_item figure img {
            object-fit: cover;
        }
    </style>
@endpush
