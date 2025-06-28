<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,' . auth()->id()],'phone_number' => ['required', 'string', 'max:255', 'unique:users,phone_number'],'phone_number' => ['required', 'string', 'max:255', 'unique:users,phone_number'],            
            'phone_number' => [
            'required',
            'string',
            'max:255',
            'unique:users,phone_number,' . auth()->id(),
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
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . auth()->id()],
            'profile_image' => ['nullable', 'file'],
        ];
    }
}
