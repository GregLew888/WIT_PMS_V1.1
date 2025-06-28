<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoldingStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'holding_status_history';

    protected $fillable = [
        'user_id',
        'holding_id',
        'new_status',
        'old_status'
    ];

    public function holding() : BelongsTo
    {
        return $this->belongsTo(Holding::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
