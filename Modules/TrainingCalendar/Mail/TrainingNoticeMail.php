<?php

namespace Modules\TrainingCalendar\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\TrainingCalendar\Models\TrainingCalendar;
use Modules\TrainingCalendar\Models\TrainingNotice;
use Modules\TrainingCalendar\Models\TrainingRegistration;

class TrainingNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public TrainingCalendar $training,
        public TrainingNotice $notice,
        public TrainingRegistration $registration,
    ) {}

    public function envelope(): Envelope
    {
        $emailSetting = setting('_email') ?? [];

        return new Envelope(
            from: !empty($emailSetting['sender_email']) && !empty($emailSetting['sender_name'])
                ? new Address($emailSetting['sender_email'], $emailSetting['sender_name'])
                : null,
            subject: $this->notice->subject,
        );
    }

    public function content(): Content
    {
        $emailSetting = setting('_email') ?? [];

        return new Content(
            view: 'trainingcalendar::emails.training-notice',
            with: [
                'signature' => $emailSetting['sender_signature'] ?? '',
                'copyright' => $emailSetting['footer_text'] ?? '',
            ],
        );
    }
}
