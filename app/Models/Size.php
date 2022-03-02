<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Size extends Model
{
    use HasFactory;

    protected $primaryKey = 'size_id';

    protected $fillable = [
        'size_name',
    ];

    public function product()
    {
        return $this->belongsToMany('App\Models\Product','product_sizes','size_id','product_id');
    }
}
