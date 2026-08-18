<?php

namespace Modules\TrainingCalendar\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\TrainingCalendar\Models\TrainingRegistration;

class TrainingRegistrationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected Collection $registrations)
    {
    }

    public function collection()
    {
        return $this->registrations;
    }

    public function map($registration): array
    {
        /** @var TrainingRegistration $registration */
        return [
            $registration->id,
            $registration->training?->title,
            $registration->name,
            $registration->email,
            $registration->phone,
            $registration->organization,
            $registration->profession,
            ucfirst($registration->payment_status),
            $registration->created_at?->format('F d, Y'),
            '',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Training',
            'Name',
            'Email',
            'Phone',
            'Organization',
            'Profession',
            'Payment Status',
            'Registered At',
            'Signature',
        ];
    }
}
