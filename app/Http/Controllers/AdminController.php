<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Categories;
use App\Models\Editor;
use App\Models\Banner;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class AdminController extends Controller
{

    public function adminInfo($id)
    {
        $info = User::selectRaw('id, name, email')
            ->where("id","=",$id)
                                ->first();
        return response()->json([
            'status'=>true,
            'info'=>$info
        ]);
    }

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

    public function banners()
    {
        $banners = Banner::with([
            "post"=>function ($query) {
                $query->select(
                    "id",
                    "title",
                    "description",
                    DB::raw("DATE_FORMAT(publish_date, '%b %d, %Y') as publish_date"),
                );
            },
            ])
            ->join('posts', 'banners.post_id', '=', 'posts.id')
            ->select(
                'banners.id',
                'banners.post_id',
            )
            ->orderBy('posts.publish_date', 'desc')
            ->get();
        return response()->json([
            'status'=>true,
            'banners'=>$banners
        ]);
    }

    public function addBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // Handle validation failure, such as returning error messages
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $banner = [
            "post_id" =>$request["post_id"]
        ];

        try{
            if (DB::table("banners")->insert($banner)) {
                return response()->json([
                    'status'=>true,
                ]);
            } else {
                return response()->json([
                    'status'=>false,
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'error'=>"Duplicate posts",
            ]);
        }
        
    }

    public function deleteBanner(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // Handle validation failure, such as returning error messages
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try{
            if (DB::table('banners')->where('id', $request['id'])->delete()) {
                return response()->json([
                    'status'=>true,
                ]);
            } else {
                return response()->json([
                    'status'=>false,
                ]);
            }
        }catch (Exception $e) {
            return response()->json([
                'error'=>"an error occurred",
            ]);
        }
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
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
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

    public function addEditor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5',
            'about' => 'required|string|min:5',
            'position' => 'required|string',
            'city' => 'required|string',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            // Handle validation failure, such as returning error messages
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $file = $request->file('image');        
        if ($file) {
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            // Storage::disk('public/posts')->put($fileName, file_get_contents($file));
            $file->storeAs('editors',$fileName, 'public');

            DB::table('editors')->insertOrIgnore([
                'name' => $request->input('name'),
                'about' => $request->input('about'),
                'position' => $request->input('position'),
                'image' => $fileName,
                'city' => $request->input('city'),
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
