<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectCategoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'study_program_id' => 'required|integer',
            'project_category_name' => [
                'required',
                'string',
                Rule::unique('project_categories', 'project_category_name')
                    ->where(function ($query) {
                        return $query->where('study_program_id', $this->study_program_id);
                    }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'study_program_id.required' => 'The study program code/name field is required.'
        ];
    }
}
