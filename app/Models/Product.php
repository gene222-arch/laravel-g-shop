<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'barcode',
        'sku',
        'title',
        'description',
        'price'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static function booted()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->barcode = uniqid('BC-');
            $product->sku = uniqid('SKU-');
        });
    }

    public function stock(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Stock::class);
    }
}
