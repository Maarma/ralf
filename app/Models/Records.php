<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    protected $table = 'records';
    protected $fillable = 
    [
        'product_id',
        'name',
        'author',
        'price',
        'image',
        'tracks'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }
    
}
