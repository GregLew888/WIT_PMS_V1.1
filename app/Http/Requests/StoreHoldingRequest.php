<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHoldingRequest extends FormRequest
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
            'user_id' => 'required|string|max:255',
            'transaction_no' => 'required|string|max:255',
            'symbol' => 'required|string|max:255',
            'stock_name' => 'required|string|max:255',
            'no_of_shares' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'transaction_type' => 'required',
            'trade_date' => 'required|date',
            'purchase' => 'required|numeric|min:0',
            'current' => 'nullable|numeric|min:0',
            'sell' => 'nullable|numeric|min:0',
            'commission' => 'nullable|numeric|min:0',
            'profit_loss' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Client is required'
        ];
    }
}
