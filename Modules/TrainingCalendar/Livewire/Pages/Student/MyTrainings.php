<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Student;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class MyTrainings extends Component
{
    use WithPagination;

    public bool $isLoading = true;

    protected TrainingCalendarService $service;

    public function mount(): void
    {
        $this->isLoading = true;
    }

    public function loadData(): void
    {
        $this->isLoading = false;
    }

    public function boot(TrainingCalendarService $service): void
    {
        $this->service = $service;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $registrations = collect();
        if (!$this->isLoading) {
            $registrations = $this->service->getStudentRegistrations(Auth::id());
        }

        return view('trainingcalendar::livewire.student.my-trainings', compact('registrations'));
    }
}
