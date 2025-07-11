<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'galleries' => 'nullable|array',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $galleries = $this->file('galleries', []);

            // Validate galleries files manually:
            if (is_array($galleries)) {
                foreach ($galleries as $index => $file) {
                    if ($file && $file->isValid()) {
                        if (!in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                            $validator->errors()->add("galleries.$index", "Gallery file at position " . ($index + 1) . " must be a JPEG or PNG image.");
                        }
                        if ($file->getSize() > 2 * 1024 * 1024) {
                            $validator->errors()->add("galleries.$index", "Gallery file at position " . ($index + 1) . " must not exceed 2MB.");
                        }
                    }
                }
            }
        });
    }
}
