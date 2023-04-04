<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json([
            "success" => true,
            "message" => "Supplier List",
            "data" => $suppliers
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
            'name' => 'required'
        ]);
        
        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => 'Validation Error.', $validator->errors()
            ], 500);      
        }

        $supplier = Supplier::create($input);
        return response()->json([
            "success" => true,
            "message" => "Supplier created successfully.",
            "data" => $supplier
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
        $supplier = Supplier::find($id);
        
        if (is_null($supplier)) {
            return response()->json([
                "success" => false,
                "message" => 'Supplier not found'
            ], 404);
        }
        
        return response()->json([
            "success" => true,
            "message" => "Supplier retrieved successfully.",
            "data" => $supplier
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
    public function update(Request $request, Supplier $supplier)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => 'Validation Error.', $validator->errors()
            ], 500);       
        }

        $supplier->name = $input['name'];
        $supplier->save();

        return response()->json([
            "success" => true,
            "message" => "Supplier updated successfully.",
            "data" => $supplier
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier->delete();
        return response()->json([
            "success" => true,
            "message" => "Supplier deleted successfully.",
            "data" => $supplier
        ], 200);
    }
}
