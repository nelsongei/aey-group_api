<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    //
    public function index()
    {
        $authors = Author::orderBy('id')->get();
        return response()->json(['authors'=>$authors]);
    }
    public function store(AuthorRequest $request)
    {
        try {
            DB::beginTransaction();
            $author = new Author();
            $author->name = $request->name;
            $author->age = $request->age;
            $author->gender = $request->gender;
            $author->country = $request->country;
            $author->genre = $request->genre;
            $author->save();
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage()]);
        }
        return response()->json(['status'=>'success','message'=>'Author Created Successfully']);
    }

}
