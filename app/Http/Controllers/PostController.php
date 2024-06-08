<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function get_post($id){
        $post = Post::with(['category:id,name,badge','editor:id,name,image,about'])
                    ->select(
                        "id",
                        "title",
                        "description",
                        "image",
                        DB::raw("DATE_FORMAT(publish_date, '%b %d, %Y') as publish_date"),
                        "cat_id",
                        "editor_id",
                        "content",
                        "views"
                        )
                    ->where('id', $id)->first();
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
        $post = Post::with(["category:id,name,badge",'editor:id,name,image'])
        ->select("id","title","description","image","highlight","publish_date","cat_id",'editor_id')
        ->orderBy('publish_date', 'desc')
        ->get();
        return response()->json([
            'status'=>true,
            'Posts'=>$post
        ]);
    }

    public function highlights()
    {
        $post = Post::with(["category:id,name,badge",'editor:id,name,image'])
        ->select("id","title","description","image","publish_date","cat_id",'editor_id')
        ->where("highlight","=",1)
        ->limit(5)
        ->orderBy('publish_date', 'desc')
        ->get();
        return response()->json([
            'status'=>true,
            'Posts'=>$post
        ]);
    }

    public function latestPosts(Request $request)
    {
        $list = $request['list']?$request['list']:1;
        $post = Post::with(["category:id,name,badge",'editor:id,name,image'])
                ->where("highlight","!=",1)
                ->select(
                    "id",
                    "title",
                    "description",
                    "image",
                    DB::raw("DATE_FORMAT(publish_date, '%b %d, %Y') as publish_date"),
                    "cat_id",
                    "editor_id"
                    )
                ->paginate(3, ['*'], 'list', $list);
        if(count($post)){
            return response()->json($post->items());
        }
        else{
            return response()->json([]);
        }
    }

    public function related_posts(Request $request)
    {
        $id = $request['id'];
        $posts = Post::with(["category:id,name,badge",'editor:id,name,image'])
            ->select(
                "id",
                "title",
                "image",
                DB::raw("DATE_FORMAT(publish_date, '%b %d, %Y') as publish_date"),
                "cat_id",
                "editor_id"
                )
            ->where("id","!=",$id)
            ->get();
        return response()->json([
            'status'=>true,
            'Posts'=>$posts
        ]);
    }

    
    public function addWatch($id)
    {
        DB::table('posts')
        ->where('id', $id)
        ->increment('views', 1);

        return response()->json(['message' => 'Record updated successfully']);
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
