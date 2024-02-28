<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all product or search by category_id paginate(10)
        $product = Product::when($request->category_id, function ($query) use ($request) {
            return $query->where('category_id', $request->category_id);
        })->paginate(10);

        try {
            return response()->json([
                'status' => 'success',
                'message' => 'Product data successfully retrieved',
                'data' => $product
            ], 200);
        } catch (Exception $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product data failed to retrieve',
                'data' => []
            ], 500);
        }
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
    public function show(string $id)
    {
        // show detail product
        $product = Product::find($id);
        try {
            return response()->json([
                'status' => 'success',
                'message' => 'Product data successfully retrieved',
                'data' => $product
            ], 200);
        } catch (Exception $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product data not found',
                'data' => []
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
