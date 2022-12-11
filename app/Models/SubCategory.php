<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
