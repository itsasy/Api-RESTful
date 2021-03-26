<?php

namespace App\Models;

class Buyer extends User
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
