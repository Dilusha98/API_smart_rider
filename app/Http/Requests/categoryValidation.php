<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class categoryValidation extends FormRequest
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
            'categoryName' => 'required|string|min:2',
            'categoryImage' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
            'catDescription' => 'required|string|max:500',
        ];
    }


    public function messages()
    {
        return [
            'categoryName.required' => 'Please enter a brand name',
            'categoryName.min' => 'Brand name must be at least 2 characters long',
            'categoryImage.required' => 'Please upload a logo',
            'categoryImage.mimes' => 'Only image files (JPG, JPEG, PNG, GIF) are allowed',
            'categoryImage.max' => 'The file size is too big (2MB max).',
            'catDescription.required' => 'Please enter a description',
            'catDescription.max' => 'Description must not exceed 500 characters.'
        ];
    }
}
