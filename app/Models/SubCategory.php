<?php

namespace App\Models;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_sub_categories');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
