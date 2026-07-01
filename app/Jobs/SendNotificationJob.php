<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\EmailNotification;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $template;
    public User $recipient;
    public array $templateData;
    public array $attachments;

    /**
     * Create a new job instance.
     */
    public function __construct(string $template, User $user, array $templateData, array $attachments = [])
    {
        $this->template         = $template;
        $this->recipient        = $user;
        $this->templateData     = $templateData;
        $this->attachments      = $attachments;
    }

    /**
     * Execute the job.
     */
    public function handle(NotificationService $notifyService): void
    {
        $template = $notifyService->parseEmailTemplate($this->template, $this->recipient->role, $this->templateData);
        if (!empty($template)) {
           $this->recipient->notify(new EmailNotification($template, $this->attachments));
        }
    }
}
