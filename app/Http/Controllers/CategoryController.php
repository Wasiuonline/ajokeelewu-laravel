<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    
    public function index(){
        $categories = Category::select("name", "slug", "id")
        ->where("category_id", "0")
        ->with("subcategories:id,category_id,name,slug")
        // ->with(["subcategories" => function($query){
        //     $query->withCount("items")
        // }])
        ->get();
        return response()->json(CategoryResource::collection($categories), 200);
    }

}
