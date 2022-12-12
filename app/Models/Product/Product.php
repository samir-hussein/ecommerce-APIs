<?php

namespace App\Models\Product;

use App\Models\Review;
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
        'img',
        'secure_url',
        'price',
        'description',
        'discount',
        'stock',
        'category_id',
        'sub_category_id',
        'brand_id',
        'seller_id',
        'approved'
    ];

    public function gallery()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
