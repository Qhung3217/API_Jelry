<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InvoiceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "invoice_id" => $this->invoice_id,
            "invoice_customer_name" => $this->invoice_customer_name,
            "invoice_customer_tels" => $this->invoice_customer_tels,
            "invoice_customer_address" => $this->invoice_customer_address,
            "invoice_date" => $this->invoice_date,
            "invoice_total" => $this->invoice_total,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }

    public static function setInvoiceRequest($request)
    {
        return [
            'invoice_customer_name' => $request->customer_name,
            'invoice_customer_email' => $request->customer_email,
            'invoice_customer_tels' => $request->customer_tel,
            'invoice_customer_province' => $request->customer_province,
            'invoice_customer_district' => $request->customer_district,
            'invoice_customer_ward' => $request->customer_ward,
            'invoice_customer_address' => $request->customer_address,
            'invoice_total' => $request->total
        ];
    }
}
