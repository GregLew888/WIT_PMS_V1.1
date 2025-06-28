<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'phone_number' => [
                'required', 'string', 'max:255', 'unique:users,phone_number',
                'regex:/^\+?[0-9]+$/', // Ensures the phone number starts with an optional '+' and contains digits only
            ],
            // 'address_line_1' => ['required', 'string', 'max:500',],
            // 'address_line_2' => ['required', 'string', 'max:500',],
            // 'city' => ['required', 'string', 'max:500',],
            // 'state' => ['required', 'string', 'max:500',],
            // 'country' => ['required', 'string', 'max:500',],
            // 'birth_date' => ['required', 'string', 'max:500',],
            // 'annual_income' => ['required', 'string', 'max:500',],
            // 'liquid_net_worth' => ['required', 'string', 'max:500',],
            // 'post_code' => ['required', 'string', 'max:500',],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            // 'role' => 'array|required|present',
            // 'profile_image' => ['nullable', 'file',],
            'password' => ['required', 'string',
                Password::min(8)
                ->numbers()->letters()->mixedCase()->symbols(), 'confirmed'],
        ];
    }
}
