<?php

namespace App\Models;

use App\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "Categories";
    protected $guarded = [];
    public $timestamps = true;

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'category_id', 'id');
    }

    public function brands()
    {
        return $this->hasMany(\App\Models\Brand::class, 'brand_id', 'id');
    }
}
