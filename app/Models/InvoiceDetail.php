<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $table = "invoice_details";

    // protected $primaryKey = ["product_id", "invoice_id"];
    protected $primaryKey = "invoice_detail_id";

    protected $fillable = [
        'invoice_detail_size',
        'invoice_detail_quantity',
        'invoice_detail_price_sell',
        'product_id',
        'invoice_id'
    ];
    // public $incrementing = false; // fix lỗi illegal offset type

}
