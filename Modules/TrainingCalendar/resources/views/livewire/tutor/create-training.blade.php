<main class="am-main">
    <div class="container">
        <div class="am-userperinfo am-create-training">
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>{{ $trainingId ? __('trainingcalendar::trainingcalendar.edit_training') : __('trainingcalendar::trainingcalendar.create_training') }}</h2>
                    <p>{{ __('trainingcalendar::trainingcalendar.training_details_desc') }}</p>
                </div>
            </div>

            <form wire:submit.prevent="save" class="am-themeform">
                <fieldset>
                    <div class="am-themeform__wrap">
                        <div class="form-group-wrap">
                            <div class="form-group @error('title') am-invalid @enderror">
                                <label class="am-label am-important">{{ __('trainingcalendar::trainingcalendar.title') }}</label>
                                <div class="form-control_wrap">
                                    <input type="text" class="form-control" wire:model="title" placeholder="{{ __('trainingcalendar::trainingcalendar.enter_title') }}">
                                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group @error('description') am-invalid @enderror">
                                <label class="am-label">{{ __('trainingcalendar::trainingcalendar.description') }}</label>
                                <div class="am-editor-wrapper">
                                    <textarea class="form-control" rows="5" wire:model="description" placeholder="{{ __('trainingcalendar::trainingcalendar.enter_description') }}"></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-group-two-wrap">
                                    <div class="form-control_wrap @error('price') am-invalid @enderror">
                                        <label class="am-label am-important">{{ __('trainingcalendar::trainingcalendar.price') }}</label>
                                        <input type="number" step="0.01" min="0" class="form-control" wire:model="price" placeholder="{{ __('trainingcalendar::trainingcalendar.enter_price') }}">
                                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-control_wrap @error('max_seats') am-invalid @enderror">
                                        <label class="am-label">{{ __('trainingcalendar::trainingcalendar.max_seats') }}</label>
                                        <input type="number" min="1" class="form-control" wire:model="max_seats" placeholder="{{ __('trainingcalendar::trainingcalendar.enter_max_seats') }}">
                                        @error('max_seats') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-group-two-wrap">
                                    <div class="form-control_wrap @error('type') am-invalid @enderror">
                                        <label class="am-label am-important">{{ __('trainingcalendar::trainingcalendar.type') }}</label>
                                        <span class="am-select">
                                            <select class="form-control am-select2" wire:model.live="type">
                                                <option value="online">{{ __('trainingcalendar::trainingcalendar.online') }}</option>
                                                <option value="offline">{{ __('trainingcalendar::trainingcalendar.offline') }}</option>
                                            </select>
                                        </span>
                                        @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    @if($type === 'offline')
                                        <div class="form-control_wrap @error('venue') am-invalid @enderror">
                                            <label class="am-label am-important">{{ __('trainingcalendar::trainingcalendar.venue') }}</label>
                                            <input type="text" class="form-control" wire:model="venue" placeholder="{{ __('trainingcalendar::trainingcalendar.enter_venue') }}">
                                            @error('venue') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-group-two-wrap">
                                    <div class="form-control_wrap @error('registration_deadline') am-invalid @enderror">
                                        <label class="am-label am-important">{{ __('trainingcalendar::trainingcalendar.registration_deadline') }}</label>
                                        <input type="datetime-local" class="form-control" wire:model="registration_deadline">
                                        @error('registration_deadline') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-control_wrap @error('event_datetime') am-invalid @enderror">
                                        <label class="am-label am-important">{{ __('trainingcalendar::trainingcalendar.event_datetime') }}</label>
                                        <input type="datetime-local" class="form-control" wire:model="event_datetime">
                                        @error('event_datetime') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group @error('status') am-invalid @enderror">
                                <label class="am-label am-important">{{ __('trainingcalendar::trainingcalendar.status') }}</label>
                                <span class="am-select">
                                    <select class="form-control" wire:model="status">
                                        <option value="draft">{{ __('trainingcalendar::trainingcalendar.draft') }}</option>
                                        <option value="published">{{ __('trainingcalendar::trainingcalendar.published') }}</option>
                                        <option value="cancelled">{{ __('trainingcalendar::trainingcalendar.cancelled') }}</option>
                                    </select>
                                </span>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="am-themeform_footer">
                    <button type="submit" class="am-btn">{{ __('trainingcalendar::trainingcalendar.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</main>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    <style>
        .am-create-training .am-themeform {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #eee;
        }
    </style>
@endpush
