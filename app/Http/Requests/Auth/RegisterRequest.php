<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            "email" => 'required|email|unique:users,email',
            "password" => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Get the custom error messages for validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return trans('validationRequest');
    }
}
