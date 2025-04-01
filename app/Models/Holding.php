<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_no',
        'symbol',
        'stock_name',
        'no_of_shares',
        'unit_price',
        'trade_date',
        'purchase',
        'current',
        'sell_after_commission',
        'debit',
        'sell',
        'commission',
        'profit_loss',
        'status',
        'total',
        'type',
        'remaining',
    ];


    
    // public function getUnitPriceAttribute($value)
    // {
    //     return $this->attributes['unit_price'] = $this->formatCurrency($value);
    // }

    // public function getPurchaseAttribute($value)
    // {
    //     return $this->attributes['purchase'] = $this->formatCurrency($value);
    // }

    // public function getCurrentAttribute($value)
    // {
    //     return $this->attributes['current'] = $this->formatCurrency($value);
    // }

    // public function getSellAttribute($value)
    // {
    //     return $this->attributes['sell'] = $this->formatCurrency($value);
    // }

    // public function getProfitLossAttribute($value)
    // {
    //     return $this->attributes['profit_loss'] = $this->formatCurrency($value);
    // }

    // public function getTotalAttribute($value)
    // {
    //     return $this->attributes['total'] = $this->formatCurrency($value);
    // }

    // public function formatCurrency($value)
    // {
    //     // dump($value);
    //     return number_format((float)$value, 2);
    // }

    /**
     * Get the client that owns the Holding
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
