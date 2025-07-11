<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_code' => 'required|string|unique:departments,department_code,' . $this->id,
            'department_name' => 'required|string|unique:departments,department_name,' . $this->id,
        ];
    }
}
