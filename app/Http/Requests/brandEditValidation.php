<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class brandEditValidation extends FormRequest
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
            'brandNameEdit' => 'required|string|min:2',
            'brandStatusEdit' => 'required|boolean',
            'brandLogoEdit' => 'sometimes|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }


    public function messages()
    {
        return [
            'brandNameEdit.required' => 'Please enter a brand name',
            'brandNameEdit.min' => 'Brand name must be at least 2 characters long',
            'brandStatusEdit.required' => 'Please select a status',
            'brandStatusEdit.boolean' => 'Invalid status value',
            'brandLogoEdit.required' => 'Please upload a logo',
            'brandLogoEdit.mimes' => 'The logo must be a file of type: jpg, jpeg, png, gif, webp.',
            'brandLogoEdit.max' => 'The logo may not be greater than 2048 kilobytes.',
        ];
    }
}
