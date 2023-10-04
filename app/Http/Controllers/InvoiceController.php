<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use DB;
use Exception;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    function createInvoice(Request $request)
    {
        DB::beginTransaction();

        try {
            $userId = $request->header('userId');
            $products = $request->input('products');

            $total = 0;
            foreach ($products as $product) {
                $total += $product->price;
            }

            $vat = ($total / 100) * 3; //3%
            $transactionId = uniqid();

            $profile = CustomerProfile::where('user_id', $userId)->first();
            $customerDetails = "Name:{$profile->cus_name},Address:{$profile->cus_add},City:{$profile->cus_city},Phone:{$profile->cus_phone}";
            $shippingDetails = "Name:{$profile->ship_name},Address:{$profile->ship_add},City:{$profile->ship_city},Phone:{$profile->ship_phone}";

            $invoice = Invoice::create([
                "total" => $total,
                "vat" => $vat,
                "payable" => $total + $vat,
                "tran_id" => $transactionId,
                "cus_details" => $customerDetails,
                "ship_details" => $shippingDetails,
                "delivery_status" => "pending",
                "payment_status" => "pending",
                "user_id" => $userId
            ]);

            $invoiceId = $invoice->id;

            foreach ($products as $product) {
                InvoiceProduct::create([
                    "invoice_id" => $invoiceId,
                    "user_id" => $userId,
                    "product_id" => $product->id
                ]);
            }

            DB::commit();

            return ResponseHelper::success('invoice created successfully', 201);

        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::failed('invoice creation failed');
        }
    }
}