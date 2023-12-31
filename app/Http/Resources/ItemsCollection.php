<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
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
    public function with_opt($perPage, $category)
    {
        $result = (new CollectionHelper)::paginate($this->collection, $perPage);
        $result["category"] = $category;
        return $result;
    }
}