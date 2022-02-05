<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'value'
    ];

    public $timestamps = false;

    protected $hidden = [
        'deleted_at'
    ];
}
