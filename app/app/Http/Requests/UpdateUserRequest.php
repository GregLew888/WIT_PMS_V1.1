<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = $this->route('user'); // Get the bound user instance
    
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,' . $user->id],
            'phone_number' => [
                'required', 'string', 'max:255', 'unique:users,phone_number,' . $user->id,
                'regex:/^\+?[0-9]+$/', // Ensures the phone number starts with an optional '+' and contains digits only
            ],            
            // 'address_line_1' => ['required', 'string', 'max:500'],
            // 'address_line_2' => ['required', 'string', 'max:500'],
            // 'city' => ['required', 'string', 'max:500'],
            // 'state' => ['string', 'max:500','nullable'],
            // 'country' => ['required', 'string', 'max:500'],
            // 'birth_date' => ['required', 'date'],
            // 'annual_income' => ['required', 'string', 'max:500'],
            // 'liquid_net_worth' => ['required', 'string', 'max:500'],
            // 'post_code' => ['required', 'string', 'max:500'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'role' => ['array', 'required', 'present'],
            'profile_image' => ['nullable', 'file'],
        ];
    }
    
}
