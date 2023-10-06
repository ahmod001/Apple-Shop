<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Helper\SSLCommerz;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductCart;
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
            $userEmail = $request->header('userEmail');
            $cartList = ProductCart::where('user_id', $userId)->get();

            // Calculate payable
            $total = 0;
            foreach ($cartList as $product) {
                $total += $product['price'];
            }

            $vat = ($total / 100) * 3; //3%
            $payable = $total + $vat;

            $transactionId = uniqid();

            $profile = CustomerProfile::where('user_id', $userId)->first();
            
            $customerDetails = "Name:{$profile->cus_name},Address:{$profile->cus_add},City:{$profile->cus_city},Phone:{$profile->cus_phone}";
            $shippingDetails = "Name:{$profile->ship_name},Address:{$profile->ship_add},City:{$profile->ship_city},Phone:{$profile->ship_phone}";

            $invoice = Invoice::create([
                "total" => $total,
                "vat" => $vat,
                "payable" => $payable,
                "tran_id" => $transactionId,
                "cus_details" => $customerDetails,
                "ship_details" => $shippingDetails,
                "delivery_status" => "pending",
                "payment_status" => "pending",
                "user_id" => $userId
            ]);

            $invoiceId = $invoice->id;

            foreach ($cartList as $product) {
                InvoiceProduct::create([
                    "invoice_id" => $invoiceId,
                    "user_id" => $userId,
                    "quantity" => $product['quantity'],
                    "product_id" => $product['id'],
                    "sale_price" => $product['price']
                ]);
            }

            $paymentMethod = SSLCommerz::initiatePayment($profile, $payable, $transactionId, $userEmail);

            DB::commit();

            return ResponseHelper::success('invoice created successfully', 201, [
                "paymentMethod" => $paymentMethod,
                "payable" => $payable,
                "vat" => $vat,
                "total" => $total
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::failed('invoice creation failed');
        }
    }

    function invoiceList(Request $request)
    {
        $userId = $request->header('userId');
        $invoices = Invoice::where('user_id', $userId)->get();
        return ResponseHelper::success(data: $invoices);
    }

    function invoiceProductList(Request $request)
    {
        $userId = $request->header('userId');
        $cartList = InvoiceProduct::where(['user_id' => $userId], ['id' => $request->invoiceId])->first();
        return ResponseHelper::success(data: $cartList);
    }

    function paymentSuccess(Request $request)
    {
        return SSLCommerz::initiateSuccess($request->query('tran_id'));
    }

    function paymentFail(Request $request)
    {
        return SSLCommerz::initiateFail($request->query('tran_id'));
    }

    function paymentCancel(Request $request)
    {
        return SSLCommerz::initiateCancel($request->query('tran_id'));
    }

    function paymentIPN(Request $request)
    {
        return SSLCommerz::initiateIPN($request->input('tran_id'), $request->input('val_id'), $request->input('status'));
    }
}