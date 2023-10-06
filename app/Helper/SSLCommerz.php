<?php
namespace App\Helper;

use App\Models\Invoice;
use App\Models\SslcommerzAccount;
use Exception;
use Illuminate\Support\Facades\Http;

class SSLCommerz
{
    public static function initiatePayment($Profile, $payable, $tranId, $userEmail)
    {
        $ssl = SslcommerzAccount::first();

        try {
            $response = Http::asForm()->post($ssl->init_url, [
                        "store_id" => $ssl->store_id,
                        "store_passwd" => $ssl->store_password,
                        "currency" => $ssl->currency,
                        "total_amount" => $payable,
                        "tran_id" => $tranId,
                        "success_url" => "$ssl->success_url?tran_id=$tranId",
                        "fail_url" => "$ssl->fail_url?tran_id=$tranId",
                        "cancel_url" => "$ssl->cancel_url?tran_id=$tranId",
                        "ipn_url" => $ssl->ipn_url,
                        "cus_name" => $Profile->cus_name,
                        "cus_email" => $Profile->cus_email,
                        "cus_add1" => $Profile->cus_add,
                        "cus_add2" => $Profile->cus_add,
                        "cus_city" => $Profile->cus_city,
                        "cus_state" => $Profile->cus_city,
                        "cus_postcode" => "1200",
                        "cus_country" => $Profile->cus_country,
                        "cus_phone" => $Profile->cus_phone,
                        "cus_fax" => $Profile->cus_phone,
                        "shipping_method" => "YES",
                        "ship_name" => $Profile->ship_name,
                        "ship_add1" => $Profile->ship_add,
                        "ship_add2" => $Profile->ship_add,
                        "ship_city" => $Profile->ship_city,
                        "ship_state" => $Profile->ship_city,
                        "ship_country" => $Profile->ship_country,
                        "ship_postcode" => "1200",
                        "product_name" => "Apple shop product",
                        "product_category" => "Apple shop category",
                        "product_profile" => "apple shop profile",
                        "product_amount" => $payable,
                    ]);

            return $response->json('desc');

        } catch (Exception $e) {
            // return $ssl;
            throw new Exception("Error Processing Request", 1);
        }
    }

    public static function initiateSuccess($tranId)
    {
        Invoice::where('tran_id', $tranId)->update([
            "payment_status" => "success"
        ]);

        return 1;
    }

    public static function initiateFail($tranId)
    {
        Invoice::where('tran_id', $tranId)->update([
            "payment_status" => "failed"
        ]);

        return 1;
    }

    public static function initiateCancel($tranId)
    {
        Invoice::where('tran_id', $tranId)->update([
            "payment_status" => "cancel"
        ]);

        return 1;
    }


    public static function initiateIPN($tran_id, $val_id, $status)
    {
        Invoice::where('tran_id', $tran_id)->update([
            "tran_id" => $tran_id,
            "val_id" => $val_id,
            "payment_status" => $status
        ]);

        return 1;
    }
}