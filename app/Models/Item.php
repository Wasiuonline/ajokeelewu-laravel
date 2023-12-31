<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ItemsSize;
use App\Models\ItemStatus;
use App\Models\SavedItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ["category_id", "item_name", "item_slug", "item_old_price", "item_price", "item_qty", "item_details", "item_status_id", "created_by", "updated_by"];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function sizes(){
        return $this->hasMany(ItemsSize::class);
    }
    public function item_status(){
        return $this->belongsTo(ItemStatus::class);
    }
    public function saved_item(){
        return $this->hasMany(SavedItem::class)->where("user_id", Auth::id());
    }
}
