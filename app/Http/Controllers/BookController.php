<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    //
    public function index()
    {
        $books  = Book::with('author')->orderBy('id')->get();
        return response()->json(['books'=>$books]);
    }
    public function store(BookRequest $request)
    {
        try {
            DB::beginTransaction();
            $book = new Book();
            $book->author_id = $request->author_id;
            $book->name = $request->name;
            $book->isbn = $request->isbn;
            $book->save();
            DB::commit();
            return response()->json(['success'=>'Successfully Added A Book']);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    public function view($id)
    {
        $book = Book::findOrFail($id);
        return response()->json(['book'=>$book]);
    }
    public function update(BookRequest $request,$id)
    {
        try {
            DB::beginTransaction();
            $book = Book::findOrFail($id);
            $book->author_id = $request->author_id;
            $book->name = $request->name;
            $book->isbn  = $request->isbn;
            $book->push();
            DB::commit();
            return response()->json(['success'=>'Successfully Updated A Book']);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
