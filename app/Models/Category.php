<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ["name", "slug", "category_id", "cat_order", "home_display"];

    public function products(){
        return $this->belongsToMany(Item::class);
    }

    public function subcategories(){
        return $this->hasMany(Category::class);
    }

}
