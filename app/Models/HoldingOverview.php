<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoldingOverview extends Model
{
    use HasFactory;

    protected $table = 'holding_overview';

    protected $fillable = [
        'user_id',
        'symbol',
        'qty', 'price'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
