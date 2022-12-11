<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'attr_name',
        'product_id'
    ];

    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
