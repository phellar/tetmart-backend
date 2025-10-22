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
        'user_id'
    ];

   
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
