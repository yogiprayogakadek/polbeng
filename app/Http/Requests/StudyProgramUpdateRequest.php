<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyProgramUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => 'required|integer',
            'study_program_name' => 'required|string|unique:study_programs,study_program_name,' . $this->id,
            'study_program_code' => 'required|string|unique:study_programs,study_program_code,' . $this->id,
        ];
    }

    public function messages()
    {
        return [
            'department_id.required' => 'The department code/name field is required.'
        ];
    }
}
