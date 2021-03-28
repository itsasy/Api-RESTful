<?php

namespace App\Models;

use App\Scopes\BuyerScope;

class Buyer extends User
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
