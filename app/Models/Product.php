<?php

namespace App\Models;


use App\Models\Rate;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'stock',
        'description',
        'image',
        'is_active'
    ];

    public function orders(){
        return $this->belongsToMany(Order::class , 'order_product')->withPivot('quantity' , 'total_price')->withTimestamps();
    }   

    public function rates(){
        return $this->hasMany(Rate::class)->orderBy('created_at', 'desc');
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
