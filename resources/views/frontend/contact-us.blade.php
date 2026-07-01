@extends('layouts.frontend-app')

@section('content')
    <div class="am-contact-wrapper py-5">
        <div class="container py-md-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 text-center mb-5">
                    <div class="am-section-head">
                        <h2 class="am-title fw-bold text-dark mb-3 mx-auto">Get in Touch</h2>
                        <p class="am-desc text-muted fs-5 mx-auto" style="max-width: 600px;">For training inquiries, corporate
                            programs, or university collaboration, please contact us.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="am-contact-sidebar">
                        <div class="am-contact-item p-4 p-md-5 border-0 rounded-4 shadow-sm bg-white">
                            <h4 class="am-subtitle fw-bold mb-4 text-dark position-relative pb-2 section-line">Contact
                                Details</h4>

                            <ul class="am-contact-list list-unstyled mb-0">
                                @if (!empty(setting('_front_page_settings.footer_contact')))
                                    <li class="d-flex align-items-start mb-4">
                                        <span class="icon-box me-3 flex-shrink-0"><i class="am-icon-call"></i></span>
                                        <div>
                                            <span
                                                class="d-block text-uppercase tracking-wider text-muted small fw-semibold">Phone
                                                / WhatsApp</span>
                                            <a href="tel:{!! setting('_front_page_settings.footer_contact') !!}"
                                                class="am-link  text-decoration-none text-dark">+880 1742
                                                719724</a>
                                        </div>
                                    </li>
                                @endif

                                @if (!empty(setting('_front_page_settings.footer_email')))
                                    <li class="d-flex align-items-start mb-4">
                                        <span class="icon-box me-3 flex-shrink-0"><i class="am-icon-email-02"></i></span>
                                        <div>
                                            <span
                                                class="d-block text-uppercase tracking-wider text-muted small fw-semibold">Email
                                                Address</span>
                                            <a href="mailto:{!! setting('_front_page_settings.footer_email') !!}"
                                                class="am-link fw-semibold text-decoration-none text-primary break-word">{!! setting('_front_page_settings.footer_email') !!}</a>
                                        </div>
                                    </li>
                                @endif
                                @if (!empty(setting('_front_page_settings.footer_address')))
                                    <li class="d-flex mb-3">
                                        <span class="am-icon-box me-3"><i class="icon-box"></i></span>
                                        <div>
                                            <span class="d-block text-muted small">Address</span>
                                            <address><i class="am-icon-location"></i>{!! setting('_front_page_settings.footer_address') !!}</address>
                                        </div>
                                    </li>
                                @endif
                            </ul>

                            <div class="am-social-wrap mt-5 pt-4 border-top">
                                <h5 class="small text-uppercase tracking-wider fw-bold text-muted mb-3">Follow Our Hub</h5>
                               
                                @if (
                                    !empty(setting('_general.fb_link')) ||
                                        !empty(setting('_general.insta_link')) ||
                                        !empty(setting('_general.linkedin_link')) ||
                                        !empty(setting('_general.yt_link')) ||
                                        !empty(setting('_general.tiktok_link')))
                                    <ul class="am-socialmedia">
                                        @if (!empty(setting('_general.fb_link')))
                                            <li>
                                                <a href="{{ setting('_general.fb_link') }}">
                                                    <i class="am-icon-facebook"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if (!empty(setting('_general.insta_link')))
                                            <li>
                                                <a href="{{ setting('_general.insta_link') }}">
                                                    <i class="am-icon-instagram"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if (!empty(setting('_general.linkedin_link')))
                                            <li>
                                                <a href="{{ setting('_general.linkedin_link') }}">
                                                    <i class="am-icon-linkedin"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if (!empty(setting('_general.yt_link')))
                                            <li>
                                                <a href="{{ setting('_general.yt_link') }}">
                                                    <i class="am-icon-youtube"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if (!empty(setting('_general.tiktok_link')))
                                            <li>
                                                <a href="{{ setting('_general.tiktok_link') }}">
                                                    <i class="am-icon-tiktok"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="am-form-card p-4 p-md-5 border-0 rounded-4 shadow-sm bg-white">
                        <h4 class="am-subtitle fw-bold mb-4 text-dark position-relative pb-2 section-line">Send an Inquiry
                        </h4>

                        <form action="{{ route('contact.inquiry') }}" method="POST" class="am-custom-form">
                            @csrf

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 mb-4 shadow-sm"
                                    role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                        <div>{{ session('success') }}</div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="am-label fw-semibold mb-2 text-dark">Full Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control am-input @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" placeholder="e.g. John Doe">
                                        @error('name')
                                            <div class="invalid-feedback fw-medium mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="am-label fw-semibold mb-2 text-dark">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                            class="form-control am-input @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" placeholder="e.g. name@example.com">
                                        @error('email')
                                            <div class="invalid-feedback fw-medium mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="am-label fw-semibold mb-2 text-dark">Contact Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="phone"
                                            class="form-control am-input @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}" placeholder="e.g. +880 1XXX XXXXXX">
                                        @error('phone')
                                            <div class="invalid-feedback fw-medium mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="am-label fw-semibold mb-2 text-dark">Organization / University</label>
                                        <input type="text" name="organization"
                                            class="form-control am-input @error('organization') is-invalid @enderror"
                                            value="{{ old('organization') }}" placeholder="Enter institution name">
                                        @error('organization')
                                            <div class="invalid-feedback fw-medium mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="am-label fw-semibold mb-2 text-dark">Designation</label>
                                        <input type="text" name="designation"
                                            class="form-control am-input @error('designation') is-invalid @enderror"
                                            value="{{ old('designation') }}" placeholder="e.g. Student / Manager">
                                        @error('designation')
                                            <div class="invalid-feedback fw-medium mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="am-label fw-semibold mb-2 text-dark">Type of Inquiry</label>
                                        <select name="inquiry_type"
                                            class="form-select am-input shadow-none @error('inquiry_type') is-invalid @enderror">
                                            <option value="training"
                                                {{ old('inquiry_type') == 'training' ? 'selected' : '' }}>Training Program
                                            </option>
                                            <option value="corporate"
                                                {{ old('inquiry_type') == 'corporate' ? 'selected' : '' }}>Corporate
                                                Program</option>
                                            <option value="university"
                                                {{ old('inquiry_type') == 'university' ? 'selected' : '' }}>University
                                                Collaboration</option>
                                            <option value="other" {{ old('inquiry_type') == 'other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                        @error('inquiry_type')
                                            <div class="invalid-feedback fw-medium mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="am-label fw-semibold mb-2 text-dark">Message</label>
                                        <textarea name="message" class="form-control am-input @error('message') is-invalid @enderror" rows="4"
                                            placeholder="How can we help you? Describe briefly..."></textarea>
                                        @error('message')
                                            <div class="invalid-feedback fw-medium mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 text-end mt-4">
                                    <button type="submit"
                                        class="am-btn am-btn-primary px-5 py-3 rounded-3 shadow-sm border-0 transition-all">Submit
                                        Inquiry</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .am-contact-wrapper {
            background-color: #f4f6f9;
        }

        .section-line::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: var(--primary-color, #007bff);
            border-radius: 2px;
        }

        .icon-box {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(var(--primary-rgb, 0, 123, 255), 0.08);
            color: var(--primary-color, #007bff);
            border-radius: 12px;
            font-size: 1.2rem;
        }

        .break-word {
            word-break: break-all;
        }

        /* Simple & Clean Social Icons (No Box/Background) */
        .am-social-btn {
            color: #6c757d;
            font-size: 1.4rem;
            transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
            text-decoration: none;
            display: inline-block;
        }

        .am-social-btn:hover {
            transform: translateY(-2px);
        }

        .am-social-btn.facebook:hover {
            color: #3b5998;
        }

        .am-social-btn.linkedin:hover {
            color: #0077b5;
        }

        .am-social-btn.youtube:hover {
            color: #ff0000;
        }

        /* Forms styling */
        .am-input {
            border: 1px solid #e0e6ed;
            padding: 0.85rem 1.1rem;
            border-radius: 10px;
            background-color: #fcfdfe;
            transition: all 0.2s ease-in-out;
            font-size: 0.95rem;
        }

        .am-input:focus {
            background-color: #fff;
            border-color: var(--primary-color, #007bff);
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb, 0, 123, 255), 0.15) !important;
        }

        .tracking-wider {
            letter-spacing: 0.05rem;
        }

        /* Button Styling */
        .am-btn-primary {
            background-color: var(--primary-color, #007bff);
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .am-btn-primary:hover {
            background-color: var(--primary-dark-color, #0056b3);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(var(--primary-rgb, 0, 123, 255), 0.3) !important;
        }

        .transition-all {
            transition: all 0.25s ease-in-out;
        }
    </style>
@endsection
