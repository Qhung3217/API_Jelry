<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name',
        'category_slug',
        'material_id',
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
