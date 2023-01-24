<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'payment_type',
        'payment_status',
        'transaction_id',
        'delivery',
        'customer_id',
    ];
}
