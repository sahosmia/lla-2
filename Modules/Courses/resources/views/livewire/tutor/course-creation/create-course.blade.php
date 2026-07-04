<div class="cr-course cr-create-course">
    <div class="container">
        <div class="am-searchhead">
            <ol class="am-breadcrumb">
                <li><a href="{{ route('courses.tutor.courses') }}" wire:navigate>{{ __('courses::courses.manage_courses') }}</a></li>
                <li><em>/</em></li>
                <li class="active"><span>{{ $id ? __('courses::courses.edit_course') : __('courses::courses.create_course') }}</span></li>
            </ol>
        </div>
        <livewire:courses::course-sidebar :tab="$tab" :id="$id" :tabs="$tabs" />
        <livewire:dynamic-component :component="'courses::course-'.$tab" :tab="$tab" :id="$id" />
    </div>
</div>
