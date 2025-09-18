<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ParticipantTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Return empty collection; just headers
        return new Collection([]);
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Employment Type', // Teaching / Non-Teaching
            'School / Office',
            'Position',
            'Email',
            'Contact Number',
        ];
    }
}
