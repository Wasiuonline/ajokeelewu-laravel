<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Country;
use App\Models\DeliveryOption;
use App\Models\PaymentMode;
use App\Models\PaymentOption;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
    public function with_opt()
    {
        $result["data"] = $this->collection;
        $result["countries"] = Country::select("id", "country", "code")->get();
        $result["delivery"] = DeliveryOption::select("id", "delivery_option", "price")->get();
        $result["payment_modes"] = PaymentMode::select("id", "mode")->where("enabled",1)->orderBy("order_id")->get();
        $result["payment_options"] = PaymentOption::select("id", "payment_option")->get();
        return $result;
    }
}
