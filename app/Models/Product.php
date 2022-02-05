<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'updated_at',
        'hidden'
    ];

    protected static function booted()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->barcode = uniqid('BC-');
            $product->sku = uniqid('SKU-');
        });
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class)
            ->as('category');
    }

    public function stock(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Stock::class);
    }
}
