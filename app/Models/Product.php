<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Product extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'product_name',
        'description',
        'price',
        'user_id',
        'product_image_url'
    ];

   
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    // product can appear in many order
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
