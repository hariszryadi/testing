<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return response()->json([
            "success" => true,
            "message" => "Item List",
            "data" => $items
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required'
        ]);
        
        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => 'Validation Error.', $validator->errors()
            ], 500);      
        }

        $item = Item::create($input);
        return response()->json([
            "success" => true,
            "message" => "Item created successfully.",
            "data" => $item
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        
        if (is_null($item)) {
            return response()->json([
                "success" => false,
                "message" => 'Item not found'
            ], 404);
        }
        
        return response()->json([
            "success" => true,
            "message" => "Item retrieved successfully.",
            "data" => $item
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => 'Validation Error.', $validator->errors()
            ], 500);       
        }

        $item->name = $input['name'];
        $item->price = $input['price'];
        $item->qty = $input['qty'];
        $item->save();

        return response()->json([
            "success" => true,
            "message" => "Item updated successfully.",
            "data" => $item
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json([
            "success" => true,
            "message" => "Item deleted successfully.",
            "data" => $item
        ], 200);
    }
}
