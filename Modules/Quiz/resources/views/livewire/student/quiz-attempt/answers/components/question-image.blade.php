@php
    $questionImageUrl = storageMediaUrl($question->thumbnail?->path);
@endphp
@if(!empty($questionImageUrl))
    <figure class="am-quizsteps_img">
        <img src="{{ $questionImageUrl }}" alt="{{ $question->title }}">
    </figure>
@endif
