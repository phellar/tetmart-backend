<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Product extends Model
{
    protected $fillable = [
        'product_name',
        'description',
        'price',
        'user_id',
        'product-image_url'
    ];

   
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    // product can appear in many order
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
