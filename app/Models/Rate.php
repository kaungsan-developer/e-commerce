<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
       protected $fillable = [
        'user_id',
        'product_id',
        'star',
        'feedback',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
