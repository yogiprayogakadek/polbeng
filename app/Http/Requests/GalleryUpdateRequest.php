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
            'galleries.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'galleries.*.image' => 'Gallery file must be an image.',
            'galleries.*.mimes' => 'Gallery file must be a type of: jpeg, png, jpg.',
            'galleries.*.max' => 'Gallery file size must not exceed 2MB.',
        ];
    }
}
