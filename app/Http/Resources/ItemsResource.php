<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "item_name" => $this->item_name, 
            "item_old_price" => GeneralHelper::APP_CURR . GeneralHelper::formatPrice($this->item_old_price), 
            "item_price" => GeneralHelper::APP_CURR . GeneralHelper::formatPrice($this->item_price),  
            "item_slug" => $this->item_slug,
            "status" => $this->item_status,
            "file_name" => URL::to(GeneralHelper::det_image("items-displayed/" . $this->id . "-" . $this->created_by . "-item-displayed-*.*", 0))
        ];
    }
}
