<?php

namespace App\Store\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'description'];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
