<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function get_post($id){
        $post = Post::with(['category:id,name,badge','editor:id,name,image,about'])->where('id', $id)->first();
        $prevPost = Post::select('id','title')
                ->where('id','<', $post->id)
                ->orderBy('id', 'desc')->first();
        $nextPost = Post::select('id','title')
                ->where('id','>', $post->id)
                ->orderBy('id', 'asc')->first();
        if(!empty($post)){
            return response()->json([
                'navs'=>[
                    'prev'=>$prevPost,
                    'next'=>$nextPost
                ],
                'Post'=>$post
            ]);
        }
        else{
            return response()->json([
                "message" => "Post not found"
            ],404);
        }
    }
    
    public function index()
    {
        $post = Post::with(["category:id,name,badge",'editor:id,name,image'])->select("id","title","description","image","publish_date","cat_id",'editor_id')->get();
        return response()->json([
            'status'=>true,
            'Posts'=>$post
        ]);
    }

    public function related_posts(Request $request)
    {
        $id = $request['id'];
        $posts = Post::with(["category:id,name,badge",'editor:id,name,image'])
            ->select("id","title","image","publish_date","cat_id","editor_id")
            ->where("id","!=",$id)
            ->get();
        return response()->json([
            'status'=>true,
            'Posts'=>$posts
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
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
