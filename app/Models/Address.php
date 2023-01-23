<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'state',
        'city',
        'address',
        'customer_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
