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
}
