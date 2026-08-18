<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Public;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\TrainingCalendar\Models\TrainingCalendar;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class TrainingDetail extends Component
{
    public ?TrainingCalendar $training = null;
    public bool $alreadyRegistered = false;

    protected TrainingCalendarService $service;

    public function boot(TrainingCalendarService $service): void
    {
        $this->service = $service;
    }

    public function mount(TrainingCalendar $training): void
    {
        if ($training->status !== TrainingCalendar::STATUS_PUBLISHED) {
            abort(404);
        }

        $this->training = $training->load('tutor.profile')->loadCount('paidRegistrations');

        if (Auth::check()) {
            $user = Auth::user();
            $this->alreadyRegistered = $this->service->userAlreadyRegistered($training->id, $user->id);
        }
    }

    public function register()
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        if (!Auth::check()) {
            $this->dispatch('showAlertMessage', type: 'error', message: __('trainingcalendar::trainingcalendar.login_required'));
            return;
        }

        if (Auth::user()->role !== 'student') {
            $this->dispatch('showAlertMessage', type: 'error', message: __('trainingcalendar::trainingcalendar.student_only'));
            return;
        }

        $response = $this->service->addToCart($this->training, Auth::user());
        $this->dispatch('showAlertMessage', type: $response['success'] ? 'success' : 'error', message: $response['message']);

        if ($response['success']) {
            return $this->redirect(route('checkout'), navigate: true);
        }
    }

    public function render()
    {
        return view('trainingcalendar::livewire.public.training-detail')
            ->extends('layouts.frontend-app', [
                'pageTitle' => $this->training->title,
                'pageDescription' => $this->training->description,
            ]);
    }
}
