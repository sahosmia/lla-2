
<section class="am-content-image-section">
    <div class="container">
        @if(!empty(pagesetting('heading'))
            || !empty(pagesetting('sub_heading'))
            || !empty(pagesetting('paragraph'))
            || !empty(pagesetting('button_text'))
            || !empty(pagesetting('image')))
            @php
                $imageOnRight = pagesetting('image_position') === 'right';
            @endphp
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-12 col-lg-6 {{ $imageOnRight ? 'order-lg-1' : 'order-lg-2' }}">
                    <div class="am-content_box am-left-text">
                        @if(!empty(pagesetting('pre_heading')))
                            <span class="am-pre-heading">{{ pagesetting('pre_heading') }}</span>
                        @endif
                        @if(!empty(pagesetting('heading'))) <h3>{!! pagesetting('heading') !!}</h3> @endif
                        @if(!empty(pagesetting('sub_heading'))) <h5 class="am-sub-heading">{{ pagesetting('sub_heading') }}</h5> @endif
                        @if(!empty(pagesetting('paragraph'))) {!! pagesetting('paragraph') !!} @endif
                        @if(!empty(pagesetting('button_text')))
                            <a href="{{ !empty(pagesetting('button_url')) ? pagesetting('button_url') : 'javascript:void(0);' }}" class="am-btn am-content-image-btn">
                                {{ pagesetting('button_text') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 {{ $imageOnRight ? 'order-lg-2' : 'order-lg-1' }}">
                    @if(!empty(pagesetting('image')) && !empty(pagesetting('image')[0]['path']))
                        <div class="am-content-image-wrap">
                            <img src="{{ url(Storage::url(pagesetting('image')[0]['path'])) }}" alt="{{ pagesetting('heading') }}" class="img-fluid">
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>

<style>
    .am-content-image-section {
        padding: 60px 0;
    }

    .am-sub-heading {
        margin: 12px 0 0;
        color: #1a344d;
        font: 600 1.25rem/1.4em "Roboto", serif;
    }

    .am-content-image-section .am-content-image-btn {
        margin-top: 28px;
        display: inline-block;
    }

    .am-content-image-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .am-content-image-wrap img {
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    @media (max-width: 991.98px) {
        .am-content-image-wrap {
            margin-bottom: 24px;
        }
    }
</style>
