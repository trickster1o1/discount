<?php

namespace App\Models;

use App\Models\Admin\Blog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogsComment extends Model
{
    use HasFactory;
    protected $fillable = ['name','comment','blog_id','email'];
    function blog() {
        return $this->belongsTo(Blog::class);
    }
}
