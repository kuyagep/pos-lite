<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ParticipantsExport implements FromCollection,  WithHeadings
{
    public function collection()
    {
        return Participant::select('full_name', 'employment_type', 'school_office', 'position', 'email', 'contact_number', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Employment Type',
            'School / Office',
            'Position',
            'Email',
            'Contact Number',
            'Registered At',
        ];
    }
}
