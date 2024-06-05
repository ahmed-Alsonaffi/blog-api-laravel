<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table = "banners";
    protected $fillable = ["post_id"];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
