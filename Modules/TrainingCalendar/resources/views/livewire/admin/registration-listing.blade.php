<main class="tb-main am-dispute-system am-enrollment-system am-training-admin">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4>{{ __('trainingcalendar::trainingcalendar.all_registrations') }} ({{ $registrations->total() }})</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform" onsubmit="event.preventDefault();">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.400ms="keyword" autocomplete="off" placeholder="{{ __('general.search') }}...">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if(!$registrations->isEmpty())
                        <table class="tb-table">
                            <thead>
                                <tr>
                                    <th>{{ __('trainingcalendar::trainingcalendar.id') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.training') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.name') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.email') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.tutor') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.payment_status') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                    <tr>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.id') }}">
                                            <span>{{ $registration->id }}</span>
                                        </td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.training') }}">
                                            <div class="am-instructor-column">
                                                <span>{{ $registration->training?->title }}</span>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.name') }}">
                                            <div class="am-instructor-column">
                                                <span>{{ $registration->name }}</span>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.email') }}">
                                            <span>{{ $registration->email }}</span>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.tutor') }}">
                                            <div class="am-instructor-column">
                                                <span>{{ $registration->training?->tutor?->profile?->full_name }}</span>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.payment_status') }}">
                                            <div class="am-status-tag">
                                                @php
                                                    $tagClass = $registration->payment_status === 'paid' ? 'tk-active' : 'tk-disabled';
                                                @endphp
                                                <em class="tk-project-tag {{ $tagClass }}">{{ ucfirst($registration->payment_status) }}</em>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.actions') }}">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text">{{ __('courses::courses.view_details') }}</span>
                                                        <a href="{{ route('trainingcalendar.detail', $registration->training?->slug) }}" target="_blank">
                                                            <i class="icon-eye"></i>
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
                            {{ $registrations->links('pagination.custom') }}
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
