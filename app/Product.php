<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'id', 'name', 'description', 'price', 'image',
    ];
    public function category()
    {
        return $this->belongsToMany(Category::class,'pro_cat');
    }
    // public function productCategories()
    // {
    //     return $this->belongsToMany(Category::class,'category_id');
    // }
}
