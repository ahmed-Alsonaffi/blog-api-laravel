<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $fillable = ["title","description", "image", "publish_date","cat_id","editor_id"];
    
    public function category()
    {
        return $this->belongsTo(Categories::class, 'cat_id');
    }
    public function editor()
    {
        return $this->belongsTo(Editor::class, 'editor_id');
    }
}
