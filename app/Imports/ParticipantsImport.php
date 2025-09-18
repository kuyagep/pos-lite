<?php

namespace App\Imports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class ParticipantsImport implements ToModel, \Maatwebsite\Excel\Concerns\WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {

        return new Participant([
            'full_name'       => $row['full_name'],
            'employment_type' => $row['employment_type'], // must match header
            'school_office'   => $row['school_office'],
            'position'        => $row['position'],
            'email'           => $row['email'],
            'contact_number'  => $row['contact_number'],
            'qr_code'         => uniqid(), // ✅ auto-generate unique QR code
        ]);
    }

    /**
     * Define validation rules for each column
     */
    public function rules(): array
    {
        return [
            '*.full_name' => ['required', 'string', 'max:255'],
            '*.school_office' => ['required', 'string', 'max:255'],
            '*.employment_type' => [
                'required',
                Rule::in(['Teaching', 'Non-Teaching']),
            ],
            '*.email' => ['nullable', 'email'],
        ];
    }

    /**
     * Customize error messages (optional)
     */
    public function customValidationMessages()
    {
        return [
            '*.full_name.required' => 'Full Name is required.',
            '*.school_name.required' => 'School Name is required.',
            '*.employment_type.in' => 'Employment Type must be either Teaching or Non-Teaching.',
            '*.email.email' => 'The email must be a valid email address.',
        ];
    }
}
