<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandValidation extends FormRequest
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
            'name' => 'required|string|min:2',
            'logo' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter a brand name',
            'name.min' => 'Brand name must be at least 2 characters long',
            'logo.required' => 'Please upload a logo',
            'logo.mimes' => 'Only image files (JPG, JPEG, PNG, GIF) are allowed',
            'logo.max' => 'The file size is too big (2MB max).',
            'status.required' => 'Please select a status',
            'status.boolean' => 'Invalid status value',
        ];
    }
}
