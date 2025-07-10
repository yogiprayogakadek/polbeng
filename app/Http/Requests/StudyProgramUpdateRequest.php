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
            'study_program_name' => 'required|string',
            'study_program_code' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'department_id.required' => 'The department code/name field is required.'
        ];
    }
}
