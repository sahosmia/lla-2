<main class="am-main">
    <div class="container">
        <div class="am-userperinfo am-send-notice">
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>{{ __('trainingcalendar::trainingcalendar.send_notice') }} - {{ $training->title }}</h2>
                    <p>{{ __('trainingcalendar::trainingcalendar.send_notice_desc') }}</p>
                </div>
            </div>

            <form wire:submit.prevent="send" class="am-themeform">
                <fieldset>
                    <div class="am-themeform__wrap">
                        <div class="form-group-wrap">
                            <div class="form-group @error('subject') am-invalid @enderror">
                                <label class="am-label am-important">{{ __('trainingcalendar::trainingcalendar.subject') }}</label>
                                <div class="form-control_wrap">
                                    <input type="text" class="form-control" wire:model="subject" placeholder="{{ __('trainingcalendar::trainingcalendar.enter_subject') }}">
                                    @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group @error('message') am-invalid @enderror">
                                <label class="am-label am-important">{{ __('trainingcalendar::trainingcalendar.message') }}</label>
                                <div class="am-editor-wrapper">
                                    <textarea class="form-control" rows="5" wire:model="message" placeholder="{{ __('trainingcalendar::trainingcalendar.enter_message') }}"></textarea>
                                    @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-group-two-wrap">
                                    <div class="form-control_wrap @error('zoom_link') am-invalid @enderror">
                                        <label class="am-label">{{ __('trainingcalendar::trainingcalendar.zoom_link') }}</label>
                                        <input type="url" class="form-control" wire:model="zoom_link" placeholder="https://zoom.us/j/...">
                                        @error('zoom_link') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-control_wrap @error('meet_link') am-invalid @enderror">
                                        <label class="am-label">{{ __('trainingcalendar::trainingcalendar.meet_link') }}</label>
                                        <input type="url" class="form-control" wire:model="meet_link" placeholder="https://meet.google.com/...">
                                        @error('meet_link') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group @error('location') am-invalid @enderror">
                                <label class="am-label">{{ __('trainingcalendar::trainingcalendar.location') }}</label>
                                <div class="form-control_wrap">
                                    <input type="text" class="form-control" wire:model="location" placeholder="{{ __('trainingcalendar::trainingcalendar.enter_location') }}">
                                    @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="am-themeform_footer">
                    <button type="submit" class="am-btn">
                        {{ __('trainingcalendar::trainingcalendar.send_email') }}
                        <i class="am-icon-send"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    <style>
        .am-send-notice .am-themeform {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #eee;
        }
    </style>
@endpush
