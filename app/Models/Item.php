<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ItemsSize;
use App\Models\ItemStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ["category_id", "item_name", "item_slug", "item_old_price", "item_price", "item_qty", "item_details", "item_status_id", "created_by", "updated_by"];

    public function category(){
        return $this->belongsToMany(Category::class);
    }
    public function sizes(){
        return $this->hasMany(ItemsSize::class);
    }
    public function status(){
        return $this->belongsTo(ItemStatus::class);
    }
}
