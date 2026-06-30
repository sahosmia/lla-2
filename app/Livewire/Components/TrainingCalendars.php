<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Modules\TrainingCalendar\Models\TrainingCalendar;

class TrainingCalendars extends Component
{
    public $trainingsLimit = 6;

    public function mount($trainingsLimit = 6)
    {
        $this->trainingsLimit = (int) $trainingsLimit ?: 6;
    }

    public static function hasTrainings(): bool
    {
        if (!function_exists('isTrainingCalendarModuleEnabled') || !isTrainingCalendarModuleEnabled()) {
            return false;
        }

        return TrainingCalendar::query()
            ->openRegistration()
            ->exists();
    }

    public function render()
    {
        $trainings = TrainingCalendar::query()
            ->openRegistration()
            ->with('tutor.profile')
            ->withCount('paidRegistrations')
            ->orderBy('event_datetime')
            ->limit($this->trainingsLimit)
            ->get();

        return view('livewire.components.training-calendars', compact('trainings'));
    }
}
