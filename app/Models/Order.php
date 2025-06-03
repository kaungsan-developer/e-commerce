<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'address',
        'phone',
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity' , 'total_price')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
    