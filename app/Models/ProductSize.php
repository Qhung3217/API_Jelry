<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $table = 'product_sizes';

    protected $primaryKey = ['size_id', 'product_id'];

    protected $fillable = [
        'product_size_quantily',
    ];

    public $incrementing = false; // Đối với những primary không phải dạng auto increment, nên thêm dòng này để tránh Illegal offset type

    // protected function setKeysForSaveQuery(Builder $query)
    // {
    //     $query
    //         ->where('size_id', '=', $this->getAttribute('size_id'))
    //         ->where('product_id', '=', $this->getAttribute('product_id'));

    //     return $query;
    // }
}
