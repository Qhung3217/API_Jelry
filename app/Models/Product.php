<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'product_slug',
        'product_price',
        'product_desc',
        'category_id',
    ];

    public function size()
    {
        return $this->belongsToMany('App\Models\Size','product_sizes','product_id','size_id')->withPivot('product_size_quantily');
    }

    public function invoice()
    {
        return $this->belongsToMany('App\Models\Invoice','invoice_details','product_id','invoice_id')->withPivot('invoice_detail_size','invoice_detail_quantily','invoice_detail_price_Sell');
    }

    public function image(){
        return $this->hasMany('App\Models\Image', 'product_id', 'product_id');
    }
}
