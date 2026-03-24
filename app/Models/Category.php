<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'parent_id', 'price', 'stock', 'description', 'image'
    ];

    /**
     * Parent category relationship
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Child categories relationship
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Products in this category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Order items in this category
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Carts with this category
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
