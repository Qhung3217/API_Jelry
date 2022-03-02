<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WrapperResource;
use App\Http\Resources\InvoiceCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new WrapperResource(Invoice::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            // $request->merge([
            //     'invoice_date' => now('Asia/Ho_Chi_Minh'),
            // ]);
            Invoice::create($request->input());
            $message = "Create successfully!!";
        }catch(Exception $e){
            $message = "Create failed. Try again!";
        }
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($invoice_id)
    {
        // return $invoice;
        try {
            $data['data'] = [Invoice::findOrFail($invoice_id),Invoice::findOrFail($invoice_id)->invoiceDetail];
            return $data;
            // return Invoice::findOrFail($invoice_id);
        } catch (ModelNotFoundException $e) {
            $message = "Invoice Id not found!";
            return $message;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        try {
            $invoice->update($request->all());
            $message = "Update invoice recored succesfully";
            return $message;
        } catch (ModelNotFoundException $e) {
            $message = "Update invoice recored failed";
            return $message;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete();
            $message = "Delete successfully!";
            return $message;
        } catch (Exception $e) {
            $message = "Delete failed!";
            return $message;
        }
    }
}
