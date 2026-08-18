
<div class="uc-sidebar_wrap">
    <div class="uc-sidebar_inner">
        <div class="uc-sidebar_title">
            <h2>{{ __('upcertify::upcertify.library_title') }}</h2>
            <a href="javascript:void(0);" class="uc-sidebar-hidebtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16" fill="none">
                    <g>
                        <path d="M4 12L12 4M4 4L12 12" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </a>
        </div>
        <div class="uc-sidebar">
            <div class="uc-elements uc-uploads" id="uploaded-attachments">
                <h3>{{ __('upcertify::upcertify.your_uploads') }}</h3>
                @if($loadingUploadedAttachments)
                    <ul class="uc-radio-section">
                        @for ($i = 0; $i < 4; $i++)
                            <li class="uc-skeleton">
                                <label class="uc-geomatric">
                                    <figure class="uc-geomatric-img"></figure>
                                </label>
                            </li>
                        @endfor
                    </ul>
                @else
                    <ul class="uc-radio-section">
                        <li data-target="#uc-addmediapopup" @click="customActiveTab('attachment', $event)" class="uc-upload-media">
                            <label for="upload-attachment">
                                <span class="uc-upload-media_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                        <path d="M14.5835 3.08496V5.38499C14.5835 6.5051 14.5835 7.06515 14.8015 7.49297C14.9932 7.8693 15.2992 8.17526 15.6755 8.367C16.1033 8.58499 16.6634 8.58499 17.7835 8.58499H20.0835M12.5835 17.585V11.585M12.5835 11.585L15.0835 14.085M12.5835 11.585L10.0835 14.085M20.5835 10.8987V14.585C20.5835 17.3852 20.5835 18.7854 20.0385 19.8549C19.5592 20.7957 18.7943 21.5606 17.8534 22.04C16.7839 22.585 15.3838 22.585 12.5835 22.585V22.585C9.78323 22.585 8.3831 22.585 7.31354 22.04C6.37273 21.5606 5.60783 20.7957 5.12846 19.8549C4.5835 18.7854 4.5835 17.3852 4.5835 14.585V10.3631C4.5835 7.77193 4.5835 6.47632 5.05209 5.47159C5.54886 4.40644 6.40497 3.55032 7.47012 3.05355C8.47486 2.58496 9.77046 2.58496 12.3617 2.58496V2.58496C13.494 2.58496 14.0601 2.58496 14.5948 2.70351C15.1641 2.82975 15.707 3.05461 16.1988 3.36792C16.6607 3.66217 17.061 4.06249 17.8617 4.86313L18.2404 5.24182C19.1051 6.10657 19.5375 6.53895 19.8467 7.04354C20.1208 7.4909 20.3229 7.97862 20.4453 8.4888C20.5835 9.06424 20.5835 9.67572 20.5835 10.8987Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <h6 class="uc-upload-media_title">{{ __('upcertify::upcertify.upload_image') }}</h6>
                            </label>
                        </li>
                        @if($uploadedAttachments && collect($uploadedAttachments)->isNotEmpty())
                            @foreach($uploadedAttachments as $attachment)
                                <li id="uploaded_attachment_{{ $attachment->id }}" class="uc-attachment-item" data-type="image" data-url="{{ Storage::url($attachment->path) }}">
                                    <div class="uc-geomatric uc-media-img">
                                        <figure class="uc-skeleton">
                                            <img src="{{ Storage::url($attachment->path) }}" alt="{{ $attachment->title }}" onload="this.parentElement.classList.remove('uc-skeleton')">
                                        </figure>
                                        <div class="uc-media-title">
                                            <i class="uc-trash" id="delete_attachment_{{ $attachment->id }}" data-id="{{ $attachment->id }}">
                                                <x-upcertify::icons.trash />
                                            </i>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                @endif
            </div>
            <div class="uc-elements uc-shaps">
                <h3>Shaps</h3>
                <ul class="uc-elements-items">
                    @foreach ($shapeIcons as $shape => $svgContent)
                        <li id="shape_{{ $shape }}"  class="uc-attachment-item " data-color="#d9d9d9" data-type="svg" data-svg='{{ $svgContent }}'>
                            {!! $svgContent !!}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="uc-elements uc-badge">
                <h3>Badge</h3>
                <ul class="uc-elements-items">
                    @foreach ($badeIcons as $badge => $svgContent)
                        <li id="badge-{{ $badge }}" class="uc-attachment-item badge-item" data-type="svg" data-svg='{{ $svgContent }}'>
                            {!! $svgContent !!}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="uc-elements uc-border-grid" id="attachments" style="display: block;">
                <h3>Broder</h3>
                <ul class="uc-radio-section uc-wrap-single">
                        @foreach ($attachments as $attachment => $svgContent)
                        <li id="attachment-{{ $attachment }}" class="uc-attachment-item" data-color="#d9d9d9" data-type="svg" data-svg='{{ $svgContent }}'>
                            <div class="uc-geomatric uc-border-box">
                                {!! $svgContent !!}
                            </div>
                        </li>
                    @endforeach         
                </ul>
            </div>
            <div class="uc-elements uc-border-grid uc-frames" id="frames" style="display: block;">
                <h3>Frames</h3>
                <ul class="uc-radio-section">
                @foreach ($frames as $frame => $contents)
                    <li id="frames-{{ $frame }}" class="uc-attachment-item" data-type="svg-frame" 
                        data-svg='{{ $contents["icon"] }}'>
                        <div class="uc-geomatric">
                            {!! $contents["thumbnail"] !!}
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="uc-sidebar_toggler">
        <span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14 6L8 12L14 18" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </div>
</div>