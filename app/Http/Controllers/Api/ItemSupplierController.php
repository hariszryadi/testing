<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemSupplier;
use Validator;

class ItemSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item_suppliers = ItemSupplier::select('items.name AS item', 'items.price', 'items.qty', 'suppliers.name AS supplier')
                    ->leftJoin('items', 'items.id', 'item_suppliers.item_id')
                    ->leftJoin('suppliers', 'suppliers.id', 'item_suppliers.supplier_id')
                    ->get();

        return response()->json([
            "success" => true,
            "message" => "Item Supplier List",
            "data" => $item_suppliers
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
            'item_id' => 'required',
            'supplier_id' => 'required'
        ]);
        
        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => 'Validation Error.', $validator->errors()
            ], 500);      
        }

        $item_supplier = ItemSupplier::create($input);
        return response()->json([
            "success" => true,
            "message" => "Item Supplier created successfully.",
            "data" => $item_supplier
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
        $item_supplier = ItemSupplier::select('items.name AS item', 'items.price', 'items.qty', 'suppliers.name AS supplier')
                    ->leftJoin('items', 'items.id', 'item_suppliers.item_id')
                    ->leftJoin('suppliers', 'suppliers.id', 'item_suppliers.supplier_id')
                    ->where('item_suppliers.id', $id)
                    ->get();
        
        if (is_null($item_supplier)) {
            return response()->json([
                "success" => false,
                "message" => 'Item Supplier not found'
            ], 404);
        }
        
        return response()->json([
            "success" => true,
            "message" => "Item Supplier retrieved successfully.",
            "data" => $item_supplier
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
    public function update(Request $request, ItemSupplier $item_supplier)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'item_id' => 'required',
            'supplier_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => 'Validation Error.', $validator->errors()
            ], 500);       
        }

        $item_supplier->item_id = $input['item_id'];
        $item_supplier->supplier_id = $input['supplier_id'];
        $item_supplier->save();

        return response()->json([
            "success" => true,
            "message" => "Item Supplier updated successfully.",
            "data" => $item_supplier
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemSupplier $item_supplier)
    {
        $item_supplier->delete();
        return response()->json([
            "success" => true,
            "message" => "Item Supplier deleted successfully.",
            "data" => $item_supplier
        ], 200);
    }
}
