<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $guarded = [];
    public $timestamps = true;

    public function category(){
        return $this->belongsTo(Category::class,'category_id' , 'id');

    }

    public function reviews(){
        return $this->hasMany(Review::class,'product_id' , 'id');

    }
    public function img(){
        return $this->belongsTo(Image::class,'image_id' , 'id');

    }
}
