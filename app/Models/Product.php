<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'primary_image',
        'price',
        'description',
        'discount',
        'stock',
        'category_id',
        'brand_id',
        'seller_id'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecifications::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
