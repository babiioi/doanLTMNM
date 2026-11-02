<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'price','sale_price', 'description', 'image', 'stock', 'collection'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function adjustStock(int $delta): void
    {
        $this->increment('stock', $delta);
        $this->variants()->update(['stock' => $this->stock]);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCurrentPriceAttribute(): float
    {
        if ($this->sale_price !== null && (float) $this->sale_price < (float) $this->price) {
            return (float) $this->sale_price;
        }
        return (float) $this->price;
    }
}
