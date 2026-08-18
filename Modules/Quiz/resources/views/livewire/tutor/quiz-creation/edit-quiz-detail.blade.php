<div class="am-createquiz">
    @include('quiz::livewire.tutor.quiz-creation.components.quiz-tab')
    <div class="am-createquiz">
        <div class="am-userperinfo am-quizsetting">
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>{{ __('quiz::quiz.qiz_details') }}</h2>
                    <p>{{ __('quiz::quiz.quiz_with_title_description') }}</p>
                </div>
            </div>
            <form wire:ignore.self class="am-themeform am-themeform_personalinfo" id="create-quiz-form">
                <fieldset>
                    <div class="form-group @error('form.title') am-invalid @enderror">
                        <label class="am-label am-important">{{ __('quiz::quiz.quiz_title') }}</label>
                        <div class="form-control_wrap">
                            <input class="form-control" wire:model="form.title" placeholder="Add title here" type="text">
                            <x-quiz::input-error field_name='form.title' />
                        </div>
                    </div>
                    <div
                        x-init="$wire.dispatch('initSelect2', {target: '#quizzable_id', data: @js($quizzable_ids)});" 
                        class="form-group @error('form.quizzable_id') am-invalid @enderror" 
                        wire:loading.class="am-disabled" 
                        wire:loading.target="form.quizzable_type"
                        >
                        <x-input-label class="am-important" for="quizzable_id">{{ isActiveModule('Courses') ? __('quiz::quiz.select_option') :  __('quiz::quiz.select_subject') }}</x-input-label>
                        <div class="form-control_wrap">
                            <span class="am-select" wire:ignore>
                                <select class="am-select2" data-componentid="@this" id="quizzable_id" data-live="true" data-searchable="true" data-wiremodel="form.quizzable_id" data-placeholder="{{ __('quiz::quiz.select_option') }}">
                                    <option value="">{{ __('quiz::quiz.select_option') }}</option>
                                </select>
                            </span>
                            <x-quiz::input-error field_name='form.quizzable_id' />
                        </div>
                    </div>
                    <div x-init="$wire.dispatch('initSummerNote', {target: '#profile_desc', wiremodel: 'form.description', conetent: `{{ $form?->description }}`, componentId: @this});" class="form-group am-custom-textarea">
                        <label class="am-label">{{ __('quiz::quiz.quiz_descriptions') }}</label>
                        <div class="am-editor-wrapper">
                            <div wire:ignore class="am-custom-editor am-custom-textarea">
                                <textarea id="profile_desc" class="form-control am-question-desc" placeholder="{{ __('profile.description_placeholder') }}" data-textarea="profile_desc">{{ $form?->description ?? '' }}</textarea>
                                <span class="characters-count"></span>
                            </div>
                            <x-input-error field_name="form.description" />
                        </div>
                    </div>
                    <div class="form-group am-form-btns">
                        <button 
                            type="button" 
                            wire:loading.class="am-btn_disable" 
                            wire:target="updateQuiz" 
                            class="am-btn" 
                            wire:click.prevent="updateQuiz">
                            {{ __('quiz::quiz.update') }}
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>    
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    @vite(['public/summernote/summernote-lite.min.css'])
@endpush

@push('scripts')
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>
    <script type="text/javascript">

        window.addEventListener('quizValuesUpdated', (event) => {            
            let { options, reset, target } = event.detail;
            initOptionList(options, target);
            if(reset) {
                jQuery(target).val('').trigger('change');
            }
        });

        function initOptionList (options, target) {
            let $select = jQuery(target);
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy').empty();
            }
            $select.select2({ 
                data: [{
                    id: '', 
                    text: 'Select an option'
                }, ...options],
                theme: 'default',
                disabled: false
            });
        }

    </script>
@endpush
