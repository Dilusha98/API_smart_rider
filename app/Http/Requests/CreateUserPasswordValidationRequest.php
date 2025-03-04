<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CreateUserPasswordValidationRequest extends FormRequest
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
            'currentPassword' => [
                'sometimes',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('The current password is incorrect.');
                    }
                },
            ],
            'newPassowrd' => [
                'required_with:currentPassword',
                'string',
                'different:currentPassword',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            //'newPassword_confirmation' => ['required_with:newPassword', 'same:newPassword'],
        ];
    }

    public function messages()
    {
        return [
            'currentPassword.sometimes' => 'The current password field is required when changing your password.',
            'currentPassword.string' => 'The current password must be a valid string.',

            'newPassowrd.required_with' => 'A new password is required when changing your password.',
            'newPassowrd.string' => 'The new password must be a valid string.',
            'newPassowrd.different' => 'The new password must be different from the current password.',
            'newPassowrd.min' => 'The new password must be at least 8 characters long.',
            'newPassowrd.mixed_case' => 'The new password must contain both uppercase and lowercase letters.',
            'newPassowrd.numbers' => 'The new password must contain at least one number.',
            'newPassowrd.symbols' => 'The new password must contain at least one symbol.',

            //'newPassword_confirmation.required_with' => 'Please confirm your new password.',
            //'newPassword_confirmation.same' => 'The new password confirmation does not match.',
        ];
    }
}
