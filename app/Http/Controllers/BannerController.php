<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::with([
            "post"=>function ($query) {
                $query->select(
                    "id",
                    "title",
                    "description",
                    "image",
                    DB::raw("DATE_FORMAT(publish_date, '%b %d, %Y') as publish_date"),
                    "cat_id",
                    "editor_id"
                );
            },
            "post.editor:id,name,image",
            "post.category:id,name,badge",
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
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        //
    }
}
