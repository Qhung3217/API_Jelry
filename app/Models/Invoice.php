<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'invoice_customer_name',
        'invoice_customer_email',
        'invoice_customer_tels',
        'invoice_customer_province',
        'invoice_customer_district',
        'invoice_customer_ward',
        'invoice_customer_address',
        'invoice_total',
    ];

    public function product()
    {
        return $this->belongsToMany('App\Models\Product', 'invoice_details', 'invoice_id','product_id')->withPivot('invoice_detail_size','invoice_detail_quantity','invoice_detail_price_sell');
    }
}
