<?php

namespace App\Models\Product;

use App\Http\Controllers\Filters\FilterServiceProvider;
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

    public static function filter(array $filters)
    {
        return FilterServiceProvider::boot(self::query(), $filters);
    }

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

    public function rating()
    {
        $no_reviews = count($this->reviews);
        $no_reviews = ($no_reviews > 0) ? $no_reviews : 1;
        return round($this->reviews->sum('rating') / $no_reviews);
    }

    public function finalPrice()
    {
        return ($this->price - ($this->price * ($this->discount / 100)));
    }
}
