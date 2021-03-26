<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const AVARIABLE_PRODUCT = '1';
    const UNAVARIABLE_PRODUCT = '0';

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'price',
        'seller_id',
    ];

    public function isAvariable()
    {
        return $this->status == Product::AVARIABLE_PRODUCT;
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
