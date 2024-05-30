<?php

namespace App\Http\Controllers;

use App\Models\Editor;
use App\Models\Post;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get_editor($id)
    {
        $Editor = Editor::where('id', $id)->first();
        $count = Post::where("editor_id","=",$id)->count();
        return response()->json([
            "editor" => $Editor,
            "count" => $count
        ]);
    }

    public function get_posts(Request $request,$id)
    {
        $list = $request['list']?$request['list']:1;
        $post = Post::with('category:id,name,badge')->where("editor_id","=",$id)->select("id","title","description","image","publish_date","cat_id")->paginate(3, ['*'], 'list', $list);
        if(count($post)){
            return response()->json($post->items());
        }
        else{
            return response()->json([]);
        }
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
    public function show(Editor $editor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Editor $editor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Editor $editor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Editor $editor)
    {
        //
    }
}
