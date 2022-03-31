<?php

namespace App\Http\Controllers\Api;

use App\Models\Size;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\DB;
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
        return Invoice::all();
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
        DB::beginTransaction();
        try{
            // $request->merge([
            //     'invoice_date' => now('Asia/Ho_Chi_Minh'),
            // ]);
            // Invoice::create($request->input());
            $invoice = InvoiceCollection::setInvoiceRequest($request);
            $invoiceAdd = Invoice::create($invoice);
            $products = $request->input('products');
            foreach ($products as $product){
                // return $product;
                $data = [
                    "invoice_detail_size" => $product['size'],
                    "invoice_detail_quantity" => $product['quantity'],
                    "invoice_detail_price_sell" => $product['price'],
                    "invoice_id" => $invoiceAdd->invoice_id,
                    "product_id" => $product["id"],
                ];
                // return $data;
                InvoiceDetail::create($data);

                $size = Size::where('size_name',$product['size'])->first();
                $productSize = ProductSize::where('product_id',$product['id'])->where('size_id',$size['size_id'])->first();
                $newquantity = $productSize["product_size_quantily"] - $product['quantity'];
                // return $newquantity;
                if ($newquantity >= 0){
                    Product::find($product['id'])->size()->updateExistingPivot($size->size_id,[
                        'product_size_quantily' => $newquantity
                    ]);

                }
                else{
                    DB::rollBack();
                    return response()->json(
                        [
                            'error' => true,
                            'title' => 'Đặt hàng thất bại',
                            'message' => 'Vui lòng thử lại'
                        ]
                    );
                }

            }

            DB::commit();
            return response()->json(
                [
                    'error' => false,
                    'title' => 'Đặt hàng thành công',
                    'message' => 'Cảm ơn bạn đã mua hàng'
                ],
                200
            );
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json(
                [
                    'error' => true,
                    'title' => 'Đặt hàng thất bại',
                    'message' => 'Vui lòng thử lại'
                ],
                500
            );
        }
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
            return response()->json([
                'message' => "Delete successfully!",
                'error' => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Delete failed! Try again",
                'error' => false
            ]);
        }
    }
}
