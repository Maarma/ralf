<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['product_id', 'name', 'quantity', 'price'];

    public function record()
    {
        return $this->belongsTo(Records::class, 'product_id', 'id');
    }
}
