<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'brand', 'description', 'price', 'stock', 'sold', 'image', 'is_best_seller'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function avgRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
