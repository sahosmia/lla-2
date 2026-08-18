<main class="am-main">
    <div class="container">
        <div class="am-quizlist am-registration-list">
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>{{ __('trainingcalendar::trainingcalendar.registrations') }} - {{ $training->title }}</h2>
                    <p>{{ __('trainingcalendar::trainingcalendar.manage_registrations_desc') }}</p>
                </div>
                <div class="am-_btn_wrap">
                    @if($registrations->isNotEmpty())
                        <a href="javascript:void(0)" wire:click="exportRegistrations" class="am-btn">
                            {{ __('general.export') }}
                            <i class="am-icon-download"></i>
                        </a>
                    @endif
                    <a href="{{ route('trainingcalendar.tutor.send-notice', $training->id) }}" class="am-btn">
                        {{ __('trainingcalendar::trainingcalendar.send_notice') }}
                        <i class="am-icon-email-02"></i>
                    </a>
                </div>
            </div>

            <div class="am-quizsearuch_header">
                <div class="am-quizlist_search">
                    <input type="text" wire:model.live.debounce.400ms="keyword" class="form-control"
                        placeholder="{{ __('general.search') }}">
                    <i class="am-icon-search-02"></i>
                </div>
            </div>

            <div class="am-table-area">
                <div class="am-courses-table">
                    @if($registrations->isNotEmpty())
                        <table class="am-table am-table-fixed">
                            <thead>
                                <tr>
                                    <th class="col-name">{{ __('trainingcalendar::trainingcalendar.name') }}</th>
                                    <th class="col-email">{{ __('trainingcalendar::trainingcalendar.email') }}</th>
                                    <th class="col-phone">{{ __('trainingcalendar::trainingcalendar.phone') }}</th>
                                    <th class="col-organization">{{ __('trainingcalendar::trainingcalendar.organization') }}</th>
                                    <th class="col-profession">{{ __('trainingcalendar::trainingcalendar.profession') }}</th>
                                    @if(isActiveModule('upcertify'))
                                        <th class="col-attendance">{{ __('trainingcalendar::trainingcalendar.attendance') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                    <tr>
                                        <td class="col-name" data-label="{{ __('trainingcalendar::trainingcalendar.name') }}">
                                            <div class="cr-image-and-text">
                                                <div class="avatar-placeholder-circle">
                                                    {{ substr($registration->name ?? 'S', 0, 1) }}
                                                </div>
                                                <span class="cr-truncate-text">{{ $registration->name }}</span>
                                            </div>
                                        </td>
                                        <td class="col-email" data-label="{{ __('trainingcalendar::trainingcalendar.email') }}"><span class="cr-truncate-text">{{ $registration->email }}</span></td>
                                        <td class="col-phone" data-label="{{ __('trainingcalendar::trainingcalendar.phone') }}">{{ $registration->phone }}</td>
                                        <td class="col-organization" data-label="{{ __('trainingcalendar::trainingcalendar.organization') }}"><span class="cr-truncate-text">{{ $registration->organization }}</span></td>
                                        <td class="col-profession" data-label="{{ __('trainingcalendar::trainingcalendar.profession') }}"><span class="cr-truncate-text">{{ $registration->profession }}</span></td>
                                        @if(isActiveModule('upcertify'))
                                            <td class="col-attendance" data-label="{{ __('trainingcalendar::trainingcalendar.attendance') }}">
                                                @if($registration->isAttended())
                                                    <div class="am-attendance-issued">
                                                        <span class="cr-status">
                                                            <span style="background-color: #008000;" class="cr-dot active"></span>
                                                            {{ __('trainingcalendar::trainingcalendar.attended') }}
                                                        </span>
                                                        @if($registration->issuedCertificate)
                                                            <a href="{{ route('upcertify.certificate', $registration->issuedCertificate->hash_id) }}" target="_blank" class="am-attendance-cert-link">
                                                                {{ __('trainingcalendar::trainingcalendar.certificate_issued') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                @elseif(!empty($training->certificate_id))
                                                    <button type="button" class="am-btn am-btn-sm" wire:click="markAttended({{ $registration->id }})" wire:confirm="{{ __('trainingcalendar::trainingcalendar.confirm_mark_attended') }}" wire:loading.attr="disabled" wire:target="markAttended({{ $registration->id }})">
                                                        {{ __('trainingcalendar::trainingcalendar.mark_attended') }}
                                                    </button>
                                                @else
                                                    <span class="cr-status">
                                                        <span style="background-color: #ff9f43;" class="cr-dot"></span>
                                                        {{ __('trainingcalendar::trainingcalendar.not_attended') }}
                                                    </span>
                                                @endif
                                            </td>
                                        @endif
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

        .am-registration-list .am-attendance-issued {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .am-registration-list .am-attendance-cert-link {
            font-size: 12px;
            font-weight: 600;
            color: #4338ca;
            text-decoration: underline;
        }

        .am-registration-list .am-btn-sm {
            padding: 6px 14px;
            font-size: 13px;
        }

        .am-registration-list .am-table-fixed {
            width: 100%;
            table-layout: fixed;
        }

        .am-registration-list .am-table-fixed .col-name { width: 20%; }
        .am-registration-list .am-table-fixed .col-email { width: 18%; }
        .am-registration-list .am-table-fixed .col-phone { width: 12%; }
        .am-registration-list .am-table-fixed .col-organization { width: 16%; }
        .am-registration-list .am-table-fixed .col-profession { width: 14%; }
        .am-registration-list .am-table-fixed .col-attendance { width: 20%; }

        .am-registration-list .am-table-fixed .cr-truncate-text {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        @media (max-width: 991px) {
            .am-registration-list .am-table-fixed {
                table-layout: auto;
            }

            .am-registration-list .am-table-fixed .cr-truncate-text {
                white-space: normal;
                overflow-wrap: anywhere;
            }
        }
    </style>
@endpush
