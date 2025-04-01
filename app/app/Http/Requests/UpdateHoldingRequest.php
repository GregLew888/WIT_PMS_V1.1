<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHoldingRequest extends FormRequest
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
            'no_of_shares' => 'required|integer|min:1',
            'trade_date' => 'required|date',
            'current' => 'required|numeric|min:0',
            'sell' => 'required|numeric|min:0',
            'commission' => 'required|numeric|min:0',
            'profit_loss' => 'required|numeric',
            'total' => 'required|numeric',
        ];
    }
}
