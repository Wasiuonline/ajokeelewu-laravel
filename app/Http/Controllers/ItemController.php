<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ItemsResource;
use App\Http\Resources\ItemsCollection;
use App\Http\Resources\CategoryResource;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function front_index(Request $request){
        $items = Item::select("id", "item_name", "item_old_price", "item_price", "item_slug", "item_qty", "created_by", "item_status_id")
        ->where("item_status_id", "1")
        ->with("item_status:id,item_status")
        ->with("sizes:item_id,size,quantity")
        ->when(Auth::check(), function($cond_req){ 
        $cond_req->withCount("saved_item");
        })
        ->limit("8")
        ->orderBy("id", "desc")
        ->get();
        return response()->json(ItemsResource::collection($items), 200);
    }

    public function front_cat(Request $request, $cat_slug){
    $cat_name = GeneralHelper::in_table("categories",[['slug', '=', $cat_slug]],"name");
    $cat_id = GeneralHelper::in_table("categories",[['slug', '=', $cat_slug]],"id");
    $parent_id = GeneralHelper::in_table("categories",[['slug', '=', $cat_slug]],"category_id");
    $parent_name = GeneralHelper::in_table("categories",[['id', '=', $parent_id]],"name");
    $category = ($cat_slug != "all")?"{$parent_name} - {$cat_name}":"All Products - Available";

    $items = Item::select("id", "item_name", "item_old_price", "item_price", "item_slug", "item_qty", "created_by", "item_status_id", "category_id")
    ->where("item_status_id", "1")
    ->when($cat_slug != "all", function($cond_req) use ($cat_id){ 
    $cond_req->where("category_id", $cat_id);
    })
    ->with("item_status:id,item_status")
    ->with("sizes:item_id,size,quantity")
    //->with("category:id,name")
    ->when(Auth::check(), function($cond_req){ 
    $cond_req->withCount("saved_item");
    })
    ->orderBy("id", "desc")
    ->get();
    return response()->json((new ItemsCollection($items))->with_opt(4, $category), 200);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
