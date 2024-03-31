<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\CartItem;
use App\Models\CartOrder;
use Illuminate\Http\Request;
use App\Models\TransactionLog;
use App\Http\Requests\CartItemRequest;
use App\Http\Requests\CartOrderRequest;

class CartOrderController extends Controller
{
    
    public function cart(CartOrderRequest $request){
        $data = $request->all();
        $items = $data["cart"];
        $data["date_time"] = GeneralHelper::gen("date_time");
        $order = CartOrder::create($data);
        foreach($items as $key => $value){
            $value["order_id"] = $order->id;
            $new_request = new CartItemRequest($value);
            CartItem::create($new_request->all());
        }
        
        $merchant_ref = GeneralHelper::gen("trans_ref");
        $details = "Payment for product order with invoice number #INV" . $order->id . ".";

        $data_array = [
        "order_id" => $order->id,
        "user_id" => $data["user_id"],
        "txnref" => $merchant_ref,
        "details" => $details,
        "amount" => $data["total"],
        "payment_means" => $data["payment_option"],
        "date_time" => GeneralHelper::gen("date_time")
        ];
        $trans = TransactionLog::create($data_array);

        $result["trans_id"] = $trans->id;
        $result["trans_ref"] = $merchant_ref;
        $result["total"] = $data["total"];

        if($data["payment_option"] == 2){

        $curl = curl_init();
        $amount = $data["total"] * 100;
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            "reference"=>$merchant_ref,
        // "currency"=>"ZAR",
            "amount"=>$amount,
            "email"=>$data["email"],
            "callback_url"=>"http://ajokeelewu.loc:3000/paystack-response"
        ]),
        CURLOPT_HTTPHEADER => [
            "authorization: Bearer sk_live_79bc3b04b3a8fec534d36e7038118545d2022d4a",
            "content-type: application/json",
            "cache-control: no-cache"
        ],
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        if($err){
        // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
        }
        $tranx = json_decode($response, true);
        $result["payment_link"] = $tranx['data']['authorization_url'];

        }

        return response()->json($result, 200);
    }
}
