<?php

namespace App\Models\Admin;

use App\Models\Admin\InternalLinks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'top_title','top_tag_line','top_desc',
        'popular_title','popular_tag_line','popular_desc',
        'eval_title','eval_tag_line','eval_desc','eval_thumb','eval_video',
        'offer_title','offer_tag_line','offer_desc',
        'gallery_title','gallery_tag_line','gallery_desc','gallery_imgA','gallery_imgB','gallery_imgC','gallery_imgD',
        'special_title','special_tag_line','special_desc',
        'recent_title','recent_tag_line','recent_desc',
        'contact_title','contact_btn','contact_link','contact_img',
        'pagea','pageb','pagec',
        'proda','cata','prodb','catb',
        'created_by','updated_by',
    ];

    public static function updateSetting($req) {
        $hh = HomeSetting::create($req);
        return $req;
    }


    public static function editSetting($req, $id) {
        $hh = HomeSetting::where('id',$id)->first();
        $hh->update($req);

        // return $hh;
    }

    public function getPage($id) {
        return InternalLinks::where('id',$id)->first();
    }
    
    public function getCat($id) {
        return Category::where('id',$id)->first();
    }
    public function getProd($id) {
        return Product::where('id',$id)->first();
    }
}
