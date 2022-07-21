<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = "brands";
    protected $guarded = [];
    public $timestamps = true;

    public function categories()
    {
        return $this->hasMany(\App\Models\Category::class, 'category_id', 'id');
    }
}
