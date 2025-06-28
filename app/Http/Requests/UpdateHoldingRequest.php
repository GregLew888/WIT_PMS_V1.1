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
            'id' => 'required|integer',
            'user_id' => 'required|integer',
            'transaction_no' => 'required|string',
            'symbol' => 'required|string',
            'stock_name' => 'required|string',
            'trade_date' => 'required|date',
            'no_of_shares' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'type' => 'required|string',
            'purchase' => 'required|numeric|min:0',
            'total' => 'required|numeric',
            'profit_loss' => 'required|numeric',
        ];
    }
}
