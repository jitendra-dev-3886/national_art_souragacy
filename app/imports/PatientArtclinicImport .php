<?php
namespace App\Imports;

use App\Models\patient\PatientArtclinic;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PatientArtclinicImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new PatientArtclinic([
            'previous_treatment' => $row['previous_treatment'],
            'quarter' => $row['quarter'],
            'year' => $row['year'],
            'clinic_id' => $row['clinic_id'],
            'clinic_level1_reg_num' => $row['clinic_level1_reg_num'],
            'name_of_clinic' => $row['name_of_clinic'],
            'patient_uhid' => $row['patient_uhid'],
            'case_of' => $row['case_of'],
            'nationality' => $row['nationality'],
            'age_of_women' => $row['age_of_women'],
            'male_factor' => $row['male_factor'] ?? 'N',
            'female_factor' => $row['female_factor'] ?? 'N',
            'userid' => auth()->id(),
            'reporting_id' => $row['reporting_id'],
            'ip' => request()->ip(),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.previous_treatment' => 'required|max:3',
            '*.quarter' => 'required|max:15',
            '*.year' => 'required|integer',
            '*.clinic_id' => 'required|max:100',
            '*.case_of' => 'required|max:5',
            '*.age_of_women' => 'nullable|integer',
            '*.male_factor' => 'nullable|in:Y,N',
            '*.female_factor' => 'nullable|in:Y,N',
        ];
    }
}