<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all address or search by user_id paginate(10)
        // $address = Address::when($request->user_id, function ($query) use ($request) {
        //     return $query->where('user_id', $request->user_id);
        // })->paginate(10);

        $address = Address::where('user_id', $request->user()->id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Address data successfully retrieved',
            'data' => $address
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data
        $this->validate($request, [
            'name' => 'required',
            'full_address' => 'required',
            'phone' => 'required',
            'prov_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'postal_code' => 'required',
            'is_default' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $address = Address::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $address
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validasi data
        $this->validate($request, [
            'name' => 'required',
            'full_address' => 'required',
            'phone' => 'required',
            'prov_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'postal_code' => 'required',
            'is_default' => 'required'
        ]);

        $address = Address::findOrFail($id);
        $address->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $address
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = Address::findOrFail($id);
        $address->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Address successfully deleted'
        ], 200);
    }
}
