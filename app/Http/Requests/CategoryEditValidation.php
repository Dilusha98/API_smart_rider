<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryEditValidation extends FormRequest
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
            'categoryEditName' => 'required|string|min:2',
            'catStatus' => 'required|boolean',
            'catEditDescription' => 'required|string|max:500',
            'categoryEditImage' => 'sometimes|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'categoryEditName.required' => 'The category name is required.',
            'categoryEditName.string' => 'The category name must be a valid string.',
            'categoryEditName.min' => 'The category name must be at least 2 characters.',

            'catStatus.required' => 'The category status is required.',
            'catStatus.boolean' => 'The category status must be Active or Inactive.',

            'catEditDescription.required' => 'The category description is required.',
            'catEditDescription.string' => 'The category description must be a valid string.',
            'catEditDescription.max' => 'The category description may not be greater than 500 characters.',

            'categoryEditImage.mimes' => 'The category image must be a file of type: jpg, jpeg, png, gif.',
            'categoryEditImage.max' => 'The category image may not be greater than 2Mb',
        ];
    }
}
