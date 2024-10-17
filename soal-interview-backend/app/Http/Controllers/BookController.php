<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::with('category')->orderBy("title", "asc")->get();
        return response()->json([
            "message" => "Data found successfully",
            "data" => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string|max:255",
            "author" => "required|string|max:255",
            "category_id" => "required|exists:categories,id"
        ]);

        // dd($request->all());
        if ($validator->fails()) {
            return response()->json([
                "message" => "Failed to create Book",
                "data" => $validator->errors()
            ], 403);
        }

        $data = Book::create([
            "title" => $request->title,
            "author" => $request->author,
            "category_id" => $request->category_id,
            "is_borrowed" => false, // Status default buku
        ]);


        return response()->json([
            "message" => "Book created successfully",
            "data" => $data
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Book::with('category')->find($id);
        if($data){
            return response()->json([
                "message" => "Book found successfully",
                "data" => $data
            ], 200);
        }else{
            return response()->json([
                "message" => "Book not found",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Book::find($id);
        if(!$data){
            return response()->json([
                "message" => "Book not found",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            "title" => "required|string|max:255",
            "author" => "required|string|max:255",
            "category_id" => "required|exists:categories,id"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Failed to update Book",
                "data" => $validator->errors()
            ], 403);
        }

        $data->update([
            "title" => $request->title,
            "author" => $request->author,
            "category_id" => $request->category_id,
        ]);


        return response()->json([
            "message" => "Book updated successfully",
            "data" => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari data Book
        $data = Book::find($id);
        if(!$data){
            return response()->json([
                "message" => "Book not found",
            ], 404);
        }

        // Hapus data book
        $data->delete();

        return response()->json([
            "message" => "Book delete successfully"
        ], 200);
    }

    // Pinjam Buku
    public function borrowBook(Request $request, $id)
    {
        $data = Book::find($id);
        
        if ($data->is_borrowed) {
            return response()->json(['message' => 'Book is already borrowed'], 400);
        }

        $data->update(['is_borrowed' => true]);
        return response()->json(['message' => 'Book borrowed successfully'], 200);
    }

    // Kembalikan Buku
    public function returnBook(Request $request, $id)
    {
        $data = Book::find($id);

        if (!$data->is_borrowed) {
            return response()->json(['message' => 'Book is not borrowed'], 400);
        }

        $data->update(['is_borrowed' => false]);
        return response()->json(['message' => 'Book returned successfully'], 200);
    }

    // Daftar Buku yang Dipinjam
    public function borrowedBooks()
    {
        $data = Book::with('category')->where('is_borrowed', true)->get();
        if($data->isEmpty()){
            return response()->json([
                "message" => "No books were borrowed",
                "data" => $data
            ], 404);
        }else {

            return response()->json([
                "message" => "Data found successfully",
                "data" => $data
            ], 200);
        }
    }

    public function edit($id)
    {
        return view('edit_book', ['id' => $id]);
    }

    public function create()
    {
        return view('create_book');
    }

}
