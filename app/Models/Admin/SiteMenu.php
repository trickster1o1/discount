<?php

namespace App\Models\Admin;

use App\Models\Admin\InternalLinks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class SiteMenu extends Model
{
    use HasFactory, Sortable;

    protected $table = 'site_menus';

    protected $fillable = ['link_type', 'parent', 'location', 'status', 'category', 'sub_category', 'topic', 'title','external_url','created_by','updated_by'];

    public $sortable = ['link_type', 'status', 'title'];

    public static function getParent($id = ''){
        $parents = SiteMenu::where('status','active')->where('parent',0)->get();
        $html = '';
        if($parents){
            foreach($parents as $parent):
                $selected = ($id == $parent->id)?'selected':'';
                $html .= '<option '.$selected.' value="'.$parent->id.'" data-location="'.$parent->location.'">'.$parent->title.'</option>';
                $childs = SiteMenu::where('status','active')->where('parent',$parent->id)->get();
                if($childs){
                    foreach($childs as $child):
                        $selected = ($id == $child->id)?'selected':'';
                        $html .= '<option '.$selected.' value="'.$child->id.'" data-location="'.$child->location.'">-'.$child->title.'</option>';
                    endforeach;
                }
            endforeach;
        }
        return $html;
    }


    public function getSubMenus($parent) {
        return Parent::where('status','active')->where('parent',$parent)->get();
    }

    public function getLink($id) {
        return InternalLinks::where('status','active')->where('id',$id)->first()->slug;
    }
}
