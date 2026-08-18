<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Tutor;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\TrainingCalendar\Exports\TrainingRegistrationsExport;
use Modules\TrainingCalendar\Mail\CertificateIssuedMail;
use Modules\TrainingCalendar\Models\TrainingRegistration;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class RegistrationListing extends Component
{
    use WithPagination;

    public int $trainingId;
    public string $keyword = '';

    protected TrainingCalendarService $service;

    public function boot(TrainingCalendarService $service): void
    {
        $this->service = $service;
    }

    public function mount(int $trainingId): void
    {
        $training = $this->service->getTraining($trainingId);

        if (empty($training) || $training->tutor_id !== Auth::id()) {
            abort(404);
        }

        $this->trainingId = $trainingId;
    }

    public function exportRegistrations()
    {
        return Excel::download(
            new TrainingRegistrationsExport($this->service->getAllTrainingRegistrations($this->trainingId)),
            'training-registrations.xlsx'
        );
    }

    public function markAttended(int $registrationId): void
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $training = $this->service->getTraining($this->trainingId);

        if (empty($training) || $training->tutor_id !== Auth::id()) {
            abort(404);
        }

        $registration = TrainingRegistration::where('id', $registrationId)
            ->where('training_calendar_id', $this->trainingId)
            ->with('user.profile')
            ->first();

        if (empty($registration)) {
            $this->dispatch('showAlertMessage', type: 'error', message: __('general.went_wrong'));
            return;
        }

        if ($registration->isAttended()) {
            return;
        }

        if (!isActiveModule('upcertify') || empty($training->certificate_id)) {
            $this->dispatch('showAlertMessage', type: 'error', message: __('trainingcalendar::trainingcalendar.no_certificate_template_set'));
            return;
        }

        $tutor = Auth::user();
        $student = $registration->user;

        $wildcardData = [
            'tutor_name' => $tutor?->profile?->full_name ?? '',
            'student_name' => $student?->profile?->full_name ?? $registration->name,
            'gender' => !empty($student?->profile?->gender) ? ucfirst($student->profile->gender) : '',
            'tutor_tagline' => $tutor?->profile?->tagline ?? '',
            'issued_by' => $tutor?->profile?->full_name ?? '',
            'platform_name' => setting('_general.site_name'),
            'platform_email' => setting('_general.site_email'),
            'course_title' => $training->title,
            'subject_name' => $training->title,
            'issue_date' => now()->format(setting('_general.date_format') ?? 'F j, Y'),
            'student_email' => $student?->email ?? $registration->email,
            'tutor_email' => $tutor?->email ?? '',
        ];

        $certificate = generate_certificate(
            template_id: $training->certificate_id,
            generated_for_type: 'App\Models\User',
            generated_for_id: $registration->user_id,
            wildcard_data: $wildcardData
        );

        $registration->update([
            'attended_at' => now(),
            'issued_certificate_id' => $certificate->id,
        ]);

        $registrationEmail = $student?->email ?? $registration->email;

        if (!empty($registrationEmail)) {
            Mail::to($registrationEmail)->send(
                new CertificateIssuedMail($training, $registration, $certificate)
            );
        }

        $this->dispatch('showAlertMessage', type: 'success', message: __('trainingcalendar::trainingcalendar.certificate_issued'));
    }

    public function updatedKeyword(): void
    {
        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $training = $this->service->getTraining($this->trainingId);
        $registrations = $this->service->getTrainingRegistrations($this->trainingId, $this->keyword);

        return view('trainingcalendar::livewire.tutor.registration-listing', compact('training', 'registrations'));
    }
}
