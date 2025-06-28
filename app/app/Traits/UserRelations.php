<?php

namespace App\Traits;

use App\Models\Holding;



trait UserRelations
{

    /**
     * Get all of the holdings for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function holdings()
    {
        return $this->hasMany(Holding::class);
    }
}