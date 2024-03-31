<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\CartOrder;
use App\Models\ItemsSize;
use App\Models\PaymentNotification;
use App\Models\TransactionLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionLogController extends Controller
{
    
    public function paystack_response(Request $request){

    $trans_ref = $username = $user_email = $invoice_no = $amount = $response_code = $response_description = "";
    $btn_class = "danger";

    $url = "https://api.paystack.co/transaction/verify/" . $request->trans_ref;

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authorization: Bearer sk_live_79bc3b04b3a8fec534d36e7038118545d2022d4a",
        "cache-control: no-cache"
    ],
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    if($err){
        // there was an error contacting the Paystack API
    die('Error: ' . $err);
    }

    $tranx = json_decode($response);

    if(!$tranx->status){
    // there was an error from the API
    die('API Error: ' . $tranx->message);
    }

    $response_code = ($tranx->data->status == "success")?"00":"11";
    $response_description = ($tranx->data->status == "success")?"Successful Transaction":ucfirst($tranx->data->status);

    /////////////////////////////////////

    $trans = TransactionLog::where('id', $request->trans_id)->first();
    $trans_id = $trans->id;
    $trans_ref = $trans->txnref;
    $order_id = $trans->order_id;
    $payment_option = $trans->payment_means;
    $confirmed = $trans->confirmed;
    $users = User::where('id', $trans->user_id)->first();
    $username = $users->name;
    $user_email = $users->email;
    $invoice_no = "INV{$order_id}";
    $amount = $trans->amount;

    if($confirmed == 0){

    $formFields = array(
    "resp" => $response_code,
    "description" => $response_description
    );
    TransactionLog::where('id', $trans_id)->update($formFields);

    if("success" == $tranx->data->status){

    $btn_class = "success";

    $data_array = array(
    "confirmed" => 1
    );
    TransactionLog::where('id', $trans_id)->update($data_array);

    $data_array = array(
    "payment_option" => $payment_option,
    "status" => 1,
    "date_confirmed" => GeneralHelper::gen("date_time")
    );
    CartOrder::where('id', $order_id)->update($data_array);

    //////===============Starts Rectifying any Previous Notification==============//////
    $note_id = PaymentNotification::where('order_id', $order_id)->value('id');
    if(!empty($note_id)){
    $data_array = array(
    "status" => 1,
    "date_confirmed" => GeneralHelper::gen("date_time")
    );
    PaymentNotification::where('id', $note_id)->update($data_array);
    }
    //////===============Ends Rectifying any Previous Notification==============//////

    /////////////////============Starts Process Item Quantity=============/////

    $cart_items = CartItem::where('order_id', $order_id)->get();
    if($cart_items->count() > 0){
    foreach($cart_items as $value){
    $size_id = $value->size_id;
    $quantity = $value->quantity;
    $data_array = [
     'quantity' => DB::raw("quantity - {$quantity}")   
    ];
    ItemsSize::where('id', $size_id)->update($data_array);
    }
    }

    /////////////////============Ends Process Item Quantity=============/////
        
    }}else if($confirmed == 1){
        $btn_class = "success";
        $trans = TransactionLog::where('id', $request->trans_id)->first();
        $response_code = $trans->resp;
        $response_description = $trans->description;
    }

    $response = [
    'trans_ref' => $trans_ref,
    'username' => $username,
    'user_email' => $user_email,
    'invoice_no' => $invoice_no,
    'amount' => $amount,
    'response_code' => $response_code,
    'response_description' => $response_description,
    'btn_class' => $btn_class
    ];

    return response()->json($response, 200);

    }

}