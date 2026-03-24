<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'total',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'location_type',
        'district',
        'street',
        'house_number',
        'village',
        'city',
        'province',
        'payment_token',
        'payment_method',
        'payment_status',
        'payment_qr',
        'payment_md5',
        'paid',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'paid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
