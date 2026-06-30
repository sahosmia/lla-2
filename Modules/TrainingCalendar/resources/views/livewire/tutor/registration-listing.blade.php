<main class="am-main">
    <div class="container">
        <div class="am-quizlist am-registration-list">
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>{{ __('trainingcalendar::trainingcalendar.registrations') }} - {{ $training->title }}</h2>
                    <p>{{ __('trainingcalendar::trainingcalendar.manage_registrations_desc') }}</p>
                </div>
                <div class="am-_btn_wrap">
                    <a href="{{ route('trainingcalendar.tutor.send-notice', $training->id) }}" class="am-btn">
                        {{ __('trainingcalendar::trainingcalendar.send_notice') }}
                        <i class="am-icon-email"></i>
                    </a>
                </div>
            </div>

            <div class="am-table-area">
                <div class="am-courses-table">
                    @if($registrations->isNotEmpty())
                        <table class="am-table">
                            <thead>
                                <tr>
                                    <th>{{ __('trainingcalendar::trainingcalendar.name') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.email') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.phone') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.profession') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.payment_status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                    <tr>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.name') }}">
                                            <div class="cr-image-and-text">
                                                <div class="avatar-placeholder-circle">
                                                    {{ substr($registration->name ?? 'S', 0, 1) }}
                                                </div>
                                                {{ $registration->name }}
                                            </div>
                                        </td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.email') }}">{{ $registration->email }}</td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.phone') }}">{{ $registration->phone }}</td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.profession') }}">{{ $registration->profession }}</td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.payment_status') }}">
                                            <div class="cr-status-wrap">
                                                @php
                                                    $dotColor = $registration->payment_status === 'paid' ? '#008000' : '#ff9f43';
                                                    $dotClass = $registration->payment_status === 'paid' ? 'active' : '';
                                                @endphp
                                                <span class="cr-status">
                                                    <span style="background-color: {{ $dotColor }};" class="cr-dot {{ $dotClass }}"></span>
                                                    {{ ucfirst($registration->payment_status) }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
        </div>
    </div>
</main>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    <style>
        .am-registration-list .avatar-placeholder-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e0e7ff;
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            margin-right: 10px;
        }
    </style>
@endpush
