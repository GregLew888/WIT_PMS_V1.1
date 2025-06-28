<?php
namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class PaginatedRequest extends FormRequest{

    public $keyword;
    public $page;
    public $client_id;
    public $per_page = 40;
    public $type;

    public function rules()
    {
        return [
            'keyword' => 'string',
            'page' => 'integer',
            'client_id' => 'integer',
            'type' => 'string'
        ];
    }
}


