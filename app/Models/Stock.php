<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'in_stock',
        'incoming_stock',
        'stock_out',
        'bad_stock',
        'minimum_level'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
