<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectCategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'study_program_id' => 'required|integer',
            'project_category_name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'study_program_id.required' => 'The study program code/name field is required.'
        ];
    }
}
