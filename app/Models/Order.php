<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'subtotal',
        'shipping_cost',
        'total_price',
        'status',
        'payment_method',
        'payment_va_name',
        'payment_va_number',
        'payment_ewallet_name',
        'payment_ewallet_number',
        'shipping_service',
        'shipping_resi',
        'transaction_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
