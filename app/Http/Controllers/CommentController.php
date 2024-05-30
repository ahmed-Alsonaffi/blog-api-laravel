<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get_comments($postId)
    {
        $comments = Comment::
            where("post_id","=",$postId)
            ->get();
        return response()->json($comments);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function add_comment(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);
        DB::table('comments')->insertOrIgnore([
            'name' => $request['name'],
            'email' => $request['email'],
            'message' => $request['message'],
            'post_id' => $request['post_id'],
        ]);

        return response()->json([
            "status"=>true
        ]);
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
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
