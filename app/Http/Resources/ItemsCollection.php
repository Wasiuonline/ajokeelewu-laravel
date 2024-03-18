<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Helpers\GeneralHelper;
use App\Helpers\CollectionHelper;

class ItemsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
    public function with_opt($perPage, $category, $item_details="")
    {
        $result = (new CollectionHelper)::paginate($this->collection, $perPage);
        $result["category"] = $category;
        if($item_details){
        $result["details"] = $item_details;  
        }
        return $result;
    }
}