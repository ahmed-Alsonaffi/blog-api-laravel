<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return response()->json([
            'status'=>true,
            'Categories'=>$categories
        ]);
//        return "Hello";
    }

    public function get_posts(Request $request)
    {
        $page = $request['page']?$request['page']:1;
        $post = Post::with('editor:id,name,image')->paginate(6, ['*'], 'page', $page);
        return response()->json([
            
            'total_size' => $post->total(),
            'Posts'=>$post->items(),
            'links' => $post,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show($id)
    {
        $category = Categories::find($id);
        if(!empty($category)){
            return response()->json($category);
        }
        else{
            return response()->json([
                "message" => "Category not found"
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
