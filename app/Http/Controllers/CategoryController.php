<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RahulHaque\Filepond\Facades\Filepond;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get data category
        $categories = Category::paginate(5);
        return view('pages.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.category.create');
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
        ]);

        // Filepond move image from tmp to Categories folder
        $newFilename = Str::after($request->input('image'), 'tmp/');
        Storage::disk('public')->move($request->input('image'), "categories/$newFilename");

        // simpan data ke database 
        $data = $request->all();
        $data['image'] = $newFilename;

        Category::create($data);
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        // get data user by id
        $category = Category::findOrFail($id);
        return view('pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        // Get data category by id
        $category = Category::findOrFail($id);

        if (Str::afterLast($request->input('image'), '/') !== Str::afterLast($request->image, '/')) {
            Storage::disk('public')->delete('categories/' . $category->image);
            $newFilename = Str::after($request->input('image'), 'tmp/');
            Storage::disk('public')->move($request->input('image'), "categories/$newFilename");
        }

        $data = $request->all();
        $data['image'] = isset($newFilename) ? $newFilename : $category->image;

        $category->update($data);
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
