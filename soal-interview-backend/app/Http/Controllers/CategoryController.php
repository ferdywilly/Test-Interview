<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::orderBy("name", "asc")->get();
        return response()->json([
            "message" => "Data Berhasil Ditemukan",
            "data" => $category
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Failed to create Category",
                "data" => $validator->errors()
            ], 403);
        }

        $category = Category::create([
            "name" => $request->name,
        ]);

        return response()->json([
            "message" => "category created successfully",
            "data" => $category
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Category::find($id);
        if($data){
            return response()->json([
                "message" => "Category found successfully",
                "data" => $data
            ], 200);
        }else{
            return response()->json([
                "message" => "Category not found",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Category::find($id);

        if(!$data){
            return response()->json([
                "message" => "Category not found",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Failed to update Category",
                "data" => $validator->errors()
            ], 403);
        }


        $data->update([
            "name" => $request->name,
        ]);

        return response()->json([
            "message" => "Category updated successfully",
            "data" => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Category::find($id);
        if(!$data){
            return response()->json([
                "message" => "Category not found",
            ], 404);
        }

        // Hapus data book
        $data->delete();

        return response()->json([
            "message" => "Category delete successfully"
        ], 200);
    }

    public function edit($id)
    {
        return view('edit_category', ['id' => $id]);
    }

    public function create()
    {
        return view('create_category');
    }
}
