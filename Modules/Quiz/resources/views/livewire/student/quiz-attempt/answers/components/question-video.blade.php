@php
    $questionVideoUrl = storageMediaUrl($question->video?->path);
@endphp
@if(!empty($questionVideoUrl))
    <figure class="am-quizsteps_video">
        <video controls preload="metadata">
            <source src="{{ $questionVideoUrl }}#t=0.1" wire:key="auth-video-src" type="video/mp4">
        </video>
    </figure>
@endif
