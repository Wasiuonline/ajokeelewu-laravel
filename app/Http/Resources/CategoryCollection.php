<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Country;
use App\Models\DeliveryOption;

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
        return $result;
    }
}
