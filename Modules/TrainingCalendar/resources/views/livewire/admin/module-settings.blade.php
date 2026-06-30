<main class="tb-main am-training-admin">
    <div class="container-fluid">
        <div class="tb-dhb-mainheading">
            <h4> {{__('trainingcalendar::trainingcalendar.module_settings')}}</h4>
        </div>
        <div class="tb-adminbox">
            <form wire:submit.prevent="save" class="am-themeform">
                <fieldset>
                    <div class="am-themeform__wrap">
                        <div class="form-group-wrap">
                            <div class="form-group">
                                <label class="am-label">{{ __('trainingcalendar::trainingcalendar.allow_free_training') }}</label>
                                <span class="am-select">
                                    <select class="form-control" wire:model="allow_free_training">
                                        <option value="yes">{{ __('general.yes') }}</option>
                                        <option value="no">{{ __('general.no') }}</option>
                                    </select>
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="am-label">{{ __('trainingcalendar::trainingcalendar.enforce_registration_deadline') }}</label>
                                <span class="am-select">
                                    <select class="form-control" wire:model="enforce_registration_deadline">
                                        <option value="yes">{{ __('general.yes') }}</option>
                                        <option value="no">{{ __('general.no') }}</option>
                                    </select>
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="am-label">{{ __('trainingcalendar::trainingcalendar.enable_seat_limit') }}</label>
                                <span class="am-select">
                                    <select class="form-control" wire:model="enable_seat_limit">
                                        <option value="yes">{{ __('general.yes') }}</option>
                                        <option value="no">{{ __('general.no') }}</option>
                                    </select>
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="am-label">{{ __('trainingcalendar::trainingcalendar.default_max_seats') }}</label>
                                <div class="form-control_wrap">
                                    <input type="number" min="1" class="form-control" wire:model="default_max_seats">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="am-label">{{ __('trainingcalendar::trainingcalendar.require_login') }}</label>
                                <div class="form-control_wrap">
                                    <input type="text" class="form-control" value="{{ __('general.yes') }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="am-themeform_footer">
                    <button type="submit" class="tb-btn">{{ __('trainingcalendar::trainingcalendar.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</main>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    <style>
        .am-training-admin .tb-adminbox {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #eee;
            margin-top: 20px;
        }
    </style>
@endpush
