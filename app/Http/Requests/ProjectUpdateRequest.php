<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_category_id' => 'required|exists:project_categories,id',
            'project_title' => 'required|string|max:255',
            'school_year' => 'required|string|max:15',
            'semester' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'poster_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_trailer_url' => 'required|url',
            'presentation_video_url' => 'required|url',
            'description' => 'required|string',

            // Project Members
            'student_name' => 'required|array|min:1',
            'student_id_number' => 'required|array|min:1',
            'student_name.*' => 'nullable|string|max:255',
            'student_id_number.*' => 'nullable|numeric|digits_between:5,20',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $names = $this->input('student_name', []);
            $ids = $this->input('student_id_number', []);

            $filledCount = 0;
            $total = max(count($names), count($ids));

            for ($i = 0; $i < $total; $i++) {
                $name = trim($names[$i] ?? '');
                $id = trim($ids[$i] ?? '');

                if ($name !== '' && $id !== '') {
                    $filledCount++;

                    if (strlen($name) < 3) {
                        $validator->errors()->add("student_name.$i", "Student name at row " . ($i + 1) . " must be at least 3 characters.");
                    }

                    if (!preg_match('/^\d{5,}$/', $id)) {
                        $validator->errors()->add("student_id_number.$i", "Student ID at row " . ($i + 1) . " must be at least 5 digits.");
                    }
                } elseif (($name !== '' && $id === '') || ($name === '' && $id !== '')) {
                    $validator->errors()->add("student_name.$i", "Both student name and ID must be filled at row " . ($i + 1) . ".");
                    $validator->errors()->add("student_id_number.$i", "Both student name and ID must be filled at row " . ($i + 1) . ".");
                }
            }

            if ($filledCount < 1) {
                $validator->errors()->add('student_name', 'At least one complete Project Member must be filled.');
            }
        });
    }


    public function messages(): array
    {
        return [
            'project_category_id.required' => 'Project Category is required.',
            'project_title.required' => 'Project Title is required.',
            'school_year.required' => 'School Year is required.',
            'semester.required' => 'Semester is required.',
            // 'poster_path.required' => 'Poster is required.',
            'presentation_video_url.required' => 'Presentation Video Url is required.',
            'video_trailer_url.required' => 'Video Trailer Url is required.',
            'description.required' => 'Description is required.',
            'student_name.required' => 'At least one member is required.',
            'student_id_number.required' => 'At least one member is required.',
            'student_id_number.*.numeric' => 'Student ID must be numeric.',
            'student_id_number.*.digits_between' => 'Student ID must be between 5 and 20 digits.',
        ];
    }
}
