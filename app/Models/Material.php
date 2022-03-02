<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class material extends Model
{
    use HasFactory;

    protected $primaryKey = 'material_id';

    protected $fillable = [
        'material_name',
        'material_slug'
    ];

    public function category(): HasMany
    {
        return $this->hasMany(Categories::class, 'material_id', 'material_id');
    }
}
