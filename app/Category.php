<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'id', 'name',
    ];
    public function product()
    {
        return $this->belongsToMany(Product::class,'pro_cat');
    }
}
