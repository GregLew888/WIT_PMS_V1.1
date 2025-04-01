<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'name' => 'required',
            'short_name' => 'required',
            'email' => 'required',
            'phone_number' => [
            'required',
            'string',
            'max:255',
            'unique:users,phone_number,' . auth()->id(),
            'regex:/^\+?[0-9]+$/', // Ensures the phone number starts with an optional '+' and contains digits only
            ],
        ];
    }
}
