<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;
use App\Models\Editor;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function categories()
    {
        $categories = Categories::selectRaw('id AS value, name AS label')
                                ->get();
        return response()->json([
            'status'=>true,
            'Categories'=>$categories
        ]);
    }

    public function editors()
    {
        $editors = Editor::selectRaw('id AS value, name AS label')
                                ->get();
        return response()->json([
            'status'=>true,
            'editors'=>$editors
        ]);
    }

    public function fetchEditors()
    {
        $editors = Editor::select("id","name","position","city")->get();
        return response()->json([
            'status'=>true,
            'editors'=>$editors
        ]);
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:5',
            'description' => 'required',
            'content' => 'required',
            'category' => 'required|integer',
            'editor' => 'required|integer',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            // Handle validation failure, such as returning error messages
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $file = $request->file('image');
        

        if ($file) {
            // Generate a unique file name
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file in the storage/app/public directory
            // Storage::disk('public/posts')->put($fileName, file_get_contents($file));
            $file->storeAs('posts',$fileName, 'public');

            DB::table('posts')->insertOrIgnore([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'content' => $request->input('content'),
                'image' => $fileName,
                'cat_id' => $request->input('category'),
                'editor_id' => $request->input('editor'),
            ]);

            return response()->json([
                'status'=>true,
            ]);
        }
        else{
            return response()->json([
                'Error'=>"Image not found",
            ]);
        }

    }
}
