<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get data product
        $products = Product::paginate(5);
        return view('pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.product.create', compact('categories'));
    }

    /**
     * Upload Filepond Image to tmp folder
     */
    public function upload(Request $request)
    {
        if ($request->file('image')) {
            $path = $request->file('image')->store('tmp', 'public');
        }
        return $path;
    }

    /**
     * Revert Filepond Image from tmp folder
     */
    public function revert(Request $request)
    {
        Storage::disk('public')->delete($request->getContent());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        // Filepond move image from tmp to Products folder
        $newFilename = Str::after($request->input('image'), 'tmp/');
        Storage::disk('public')->move($request->input('image'), "products/$newFilename");

        // simpan data ke database 
        $data = $request->all();
        $data['image'] = $newFilename;

        Product::create($data);
        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        // get data user by id
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.product.edit', compact(['categories', 'product']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        // Get data product by id
        $product = Product::findOrFail($id);

        if (Str::afterLast($request->input('image'), '/') !== Str::afterLast($request->image, '/')) {
            Storage::disk('public')->delete('products/' . $product->image);
            $newFilename = Str::after($request->input('image'), 'tmp/');
            Storage::disk('public')->move($request->input('image'), "products/$newFilename");
        }

        $data = $request->all();
        $data['image'] = isset($newFilename) ? $newFilename : $product->image;

        $product->update($data);
        return redirect()->route('product.index')->with('update', 'Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        // get data product by id
        $product = Product::findOrFail($id);
        Storage::disk('public')->delete('products/' . $product->image);
        $product->delete();
        return redirect()->route('product.index')->with('destroy', 'Product successfully deleted');
    }
}
