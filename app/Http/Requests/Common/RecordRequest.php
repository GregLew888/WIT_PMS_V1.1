<?php
namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class RecordRequest extends FormRequest{
    public $id;

    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    public function rules()
    {
        return [
            'id' => 'integer'
        ];
    }
}
