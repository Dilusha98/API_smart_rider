<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CreateUserRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'firatName' => ['required', 'string', 'max:50'],
            'LastName' => ['required', 'string', 'max:50'],
            'phoneNo' => ['required', 'min:10', 'max:15', Rule::unique('users', 'phone')->ignore($request->userId, 'id')],
            'userEmail' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($request->userId, 'id'), 'email:rfc,dns'],
            'userName' => ['required', 'string', 'min:3', 'max:30', Rule::unique('users', 'username')->ignore($request->userId, 'id')],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'dob' => ['nullable', 'date', 'before_or_equal:today'],
            'address' => [],
            'userRole' => ['required'],

            //'newPassowrd' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],


        ];
    }

    public function messages()
    {
        return [
            'firatName.required' => 'First name is required.',
            'firatName.string' => 'First name must be a string.',
            'firatName.max' => 'First name cannot exceed 50 characters.',

            'LastName.required' => 'Last name is required.',
            'LastName.string' => 'Last name must be a string.',
            'LastName.max' => 'Last name cannot exceed 50 characters.',

            'phoneNo.required' => 'Phone number is required.',
            'phoneNo.min' => 'Phone number must be at least 10 characters.',
            'phoneNo.max' => 'Phone number cannot exceed 15 characters.',
            'phoneNo.unique' => 'This phone number is already in use.',

            'userEmail.required' => 'Email address is required.',
            'userEmail.email' => 'Please enter a valid email address.',
            'userEmail.max' => 'Email address cannot exceed 255 characters.',
            'userEmail.unique' => 'This email address is already in use.',

            'userName.required' => 'Username is required.',
            'userName.string' => 'Username must be a string.',
            'userName.min' => 'Username must be at least 3 characters.',
            'userName.max' => 'Username cannot exceed 30 characters.',
            'userName.unique' => 'This username is already taken.',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.mixed_case' => 'Password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'Password must contain at least one number.',
            'password.symbols' => 'Password must contain at least one symbol.',

            'dob.before_or_equal' => 'Date of birth must be today or before.',

            'userRole.required' => 'User role is required.',

        ];
    }
}
