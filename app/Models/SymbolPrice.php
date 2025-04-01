<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SymbolPrice extends Model
{
    use HasFactory;

    protected $table = 'symbol_prices';

    protected $fillable = [
        'symbol',
        'open',
        'close',
        'low',
        'high',
        'previous_close',
        'pull_at'
    ];
}
