<?php

namespace App\Models\Admin;

use App\Models\Album;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallary extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = ['album_id', 'image_url','video_url', 'title', 'descrpition'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
