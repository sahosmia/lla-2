<?php

namespace Modules\TrainingCalendar\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\TrainingCalendar\Models\TrainingCalendar;
use Modules\TrainingCalendar\Models\TrainingRegistration;
use Modules\Upcertify\Models\Certificate;

class CertificateIssuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public TrainingCalendar $training,
        public TrainingRegistration $registration,
        public Certificate $certificate,
    ) {}

    public function envelope(): Envelope
    {
        $emailSetting = setting('_email') ?? [];

        return new Envelope(
            from: !empty($emailSetting['sender_email']) && !empty($emailSetting['sender_name'])
                ? new Address($emailSetting['sender_email'], $emailSetting['sender_name'])
                : null,
            subject: __('trainingcalendar::trainingcalendar.certificate_issued_email_subject', ['training' => $this->training->title]),
        );
    }

    public function content(): Content
    {
        $emailSetting = setting('_email') ?? [];

        return new Content(
            view: 'trainingcalendar::emails.certificate-issued',
            with: [
                'signature' => $emailSetting['sender_signature'] ?? '',
                'copyright' => $emailSetting['footer_text'] ?? '',
                'viewUrl' => route('upcertify.certificate', $this->certificate->hash_id),
                'downloadUrl' => route('upcertify.download', $this->certificate->hash_id),
            ],
        );
    }
}
