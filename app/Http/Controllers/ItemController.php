<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Resources\ItemsResource;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function front_index(){
        $items = Item::select("id", "item_name", "item_old_price", "item_price", "item_slug", "created_by")
        ->with("status:id,category_id,name,slug")
        ->where("item_status_id", "1")
        ->with("status:id,item_status")
        ->get();
        $items["file_name"] = GeneralHelper::det_image("items-displayed/" . $items->id . "-" . $items->created_by . "-item-displayed-*.*", 0);
        return response()->json(ItemsResource::collection($items), 200);
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