<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Http\Controllers\Controller;
use App\Http\Resources\WrapperResource;
use Illuminate\Database\QueryException;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new WrapperResource(InvoiceDetail::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            InvoiceDetail::create($request->input());
            $message = "Create successfully!!";
        }catch(Exception $e){
            $message = "Create failed. Try again!";
        }
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceDetail  $invoiceDetail
     * @return \Illuminate\Http\Response
     */
    public function show($invoice_id)
    {
        // try {
        //     $data['data'] = [Invoice::findOrFail($invoice_id),Invoice::findOrFail($invoice_id)->invoiceDetail];
        //     return $data;
        // } catch (ModelNotFoundException $e) {
        //     $message = "Invoice Id not found!";
        //     return $message;
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceDetail  $invoiceDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceDetail $invoiceDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceDetail  $invoiceDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $invoice_detail_id)
    {
        try {
            $invoiceDetail = InvoiceDetail::find($invoice_detail_id);
            // return $invoiceDetail;
            if ($invoiceDetail != null) {
                // $data = $request->input();
                // if ($request->input('product_id_new')){
                //     $data['product_id']=$data['product_id_new'];
                //     unset($data['product_id_new']);
                //     unset($data['product_id_current']);
                // }else{
                //     $data['product_id']=$request->input('product_id_current');
                //     unset($data['product_id_current']);
                // }
                // $invoiceDetail->product()->updateExistingPivot($request->input('product_id_current'),$data);
                $invoiceDetail->update($request->all());
                return "Update invoice detail recored succesfully";
            }else
                return "Error, primary key not found";
        } catch (Exception $e) {
            // return "Error, update failed";
            return $e->getMessage();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceDetail  $invoiceDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($inv_prod_id)
    {
    }
}
