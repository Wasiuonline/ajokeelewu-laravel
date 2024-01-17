<?php

namespace App\Http\Controllers;

use App\Models\SavedItem;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;

class SavedItemController extends Controller
{

    public function front_save(Request $request, $item_id)
    {
        $det_saved_id = GeneralHelper::in_table("saved_items",[['item_id', '=', $item_id], ['user_id', '=', auth()->user()->id]],"id");
        if($det_saved_id){
            SavedItem::where('id', $det_saved_id)->delete();
        }else{
            $formFields = $request->validate([
                'item_id' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/'
            ]);	
            $formFields["user_id"] = auth()->user()->id;
            SavedItem::create($formFields);
        }
    }
    /**
     * Display a listing of the resource.
     */
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
    public function show(SavedItem $savedItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavedItem $savedItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavedItem $savedItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavedItem $savedItem)
    {
        //
    }
}
