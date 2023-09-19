<?php
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if(!function_exists('alert')){
    function alert($message, $type = 'success'){
        return "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
        $message
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
}

if(!function_exists('swal')){
  function swal($title, $message, $type = 'success'){
    return "
      <script>Swal.fire('$title','$message','$type');</script>
    ";
  }
}

if(!function_exists('set_order_by')){
  function set_order_by($id,$table){
    DB::table($table)->where('id',$id)->update(['order_by'=>$id]);
  }
}
if(!function_exists('set_created_by')){
  function set_created_by($id,$table,$creator,$action){
    if($action == 1) {
      DB::table($table)->where('id',$id)->update(['created_by'=>$creator]);
    } else {
      DB::table($table)->where('id',$id)->update(['updated_by'=>$creator]);
    }
  }
}

if(!function_exists('returnMedia')){
    function returnMedia($siteSetting) {
        if($siteSetting->twitter_link) {
            echo '<a href="'.$siteSetting->twitter_link.'" target="_blank"><i class="fab fa-twitter"></i></a>';
        }
        if($siteSetting->fb_link) {
            echo '<a href="'.$siteSetting->fb_link.'"  target="_blank"><i class="fab fa-facebook"></i></a>';
        } 
        if($siteSetting->pintrest_link) {
            echo '<a href="'.$siteSetting->pintrest_link.'" target="_blank"><i class="fab fa-pinterest-p"></i></a>';
        }
        if($siteSetting->youtube_link){
          echo '<a href="'.$siteSetting->youtube_link.'" target="_blank"><i class="fab fa-youtube"></i></a>';
        }
        if($siteSetting->ig_link){
          echo '<a href="'.$siteSetting->ig_link.'" target="_blank"><i class="fab fa-instagram"></i></a>';
        }
        if($siteSetting->linkedin_link){
          echo '<a href="'.$siteSetting->linkedin_link.'" target="_blank"><i class="fab fa-linkedin"></i></a>';
        }
        if($siteSetting->viber){
          echo '<a href="viber://chat/?number=%2B'.$siteSetting->viber.'" target="_blank"><i class="fab fa-viber"></i></a>';
        }        
        if($siteSetting->skype_link){
          echo '<a href="skype:'.$siteSetting->skype_link.'?call" target="_blank"><i class="fab fa-skype"></i></a>';
        }

    }
}

if(!function_exists('get_meta_detail')){
  function get_meta_detail($site_setting=null,$data=null){
    $logo = url('').'/'.$site_setting->primary_logo;
    $meta['meta_title']       = check_empty($site_setting->meta_key)?$site_setting->meta_key:$site_setting->title;
    $meta['meta_description'] = check_empty($site_setting->meta_description)?$site_setting->meta_description:$site_setting->title;
    $meta['fb_title'] = check_empty($site_setting->fb_title)?$site_setting->fb_title:$meta['meta_title'];
    $meta['fb_description'] = check_empty($site_setting->fb_description)?$site_setting->fb_description:$meta['meta_description'];
    $meta['fb_image'] = check_empty($site_setting->fb_image)?url('').'/'.$site_setting->fb_image:$logo;

    $meta['twitter_title'] = check_empty($site_setting->twitter_title)?$site_setting->twitter_title:$meta['meta_title'];
    $meta['twitter_description'] = check_empty($site_setting->twitter_description)?$site_setting->twitter_description:$meta['meta_description'];
    $meta['twitter_image'] = check_empty($site_setting->twitter_image)?url('').'/'.$site_setting->twitter_image:$logo;

    if($data){
      $meta['meta_title'] = check_empty($data->meta_key)?$data->meta_key:(check_empty($data->title)?$data->title:$meta['meta_title']);
      $meta['meta_description'] = check_empty($data->meta_description)?$data->meta_description:$meta['meta_title'];
      $meta['fb_title'] = check_empty($data->fb_title)?$data->fb_title:$meta['meta_title'];
      $meta['fb_description'] = check_empty($data->fb_description)?$data->fb_description:$meta['meta_description'];
      $meta['fb_image'] = check_empty($data->fb_image)?url('').'/'.$data->fb_image:$logo;

      $meta['twitter_title'] = check_empty($data->twitter_title)?$data->twitter_title:$meta['meta_title'];
      $meta['twitter_description'] = check_empty($data->twitter_description)?$data->twitter_description:$meta['meta_description'];
      $meta['twitter_image'] = check_empty($data->twitter_image)?url('').'/'.$data->twitter_image:$logo;
    }
    return $meta;
  }
}

if(!function_exists('check_empty')){
  function check_empty($string=null){
    return (strlen(trim($string)) > 0)?true:false;//not necessary function
  }
}

if(!function_exists('getCorrectUrlByMenuID')){
  function getCorrectUrlByMenuID($id=''){
    $query = DB::table('site_menus')->where('id','=',$id)->where('status','active')->first();
    if($query){
      $menu_data = getCorrectURL($query);
      return $menu_data;
    }else{
      $data['title']      = '';
      $data['target']     = '';
      $data['siteurl']    = 'javascript:void(0);';
      return $data;
    }
  }
}

if(!function_exists('getCorrectURL')){
  function getCorrectURL($menu,$icon_class=''){
    $target    = '';
    $link_type = strtolower($menu->link_type);
    if($link_type == 'file'){
      if ($menu->file && strpos($menu->file, 'http') !== false) {
        $target = 'target="_blank" rel="nofollow"';
        $siteurl = $menu->file;
      } else {
        $target = 'target="_blank"';
        $siteurl = url('').'/'.$menu->file;
      }
    }elseif($link_type == 'external_url'){
      if ($menu->external_url && strpos($menu->external_url, 'http') !== false) {
        $target = 'target="_blank" rel="nofollow"';
        $siteurl = $menu->external_url;
      } else {
        if($menu->external_url == '/'){
          $siteurl = url('');
        }else{
          $siteurl = url('').'/'.$menu->external_url;
        }
      }
    }elseif($link_type == 'internal_link'){
      $slug = getSlugByID($link_type,$menu->topic);
      $siteurl = url('').'/'.$slug;
    }elseif($link_type == 'none'){
      $siteurl   = 'javascript:void(0);';
    }else{
      $slug = getSlugByID($link_type,$menu->topic);
      $siteurl   = url('').'/'.$link_type.'/'.$slug;
    }
    $data['siteurl'] = $siteurl;
    $data['target']  = $target;
    $data['title']   = $menu->title;
    return $data;
  }
}

if(!function_exists('getSlugByID')){
  function getSlugByID($table,$id){
    $table = $table.'s';
    $query = DB::table($table)->select('slug')->where('id','=',$id)->first();
    $slug = null;
    if($query){
      $slug = $query->slug;
    }
    return $slug;
  }
}

if(!function_exists('main_menu')){
  function main_menu(){
    $level1 = getMenuData(0);
    $menu = '<ul class="main-menu__list">';
    if($level1){//has top level menu
      foreach($level1 as $menu1):
        $menu_data1 = getCorrectURL($menu1);
        $level2 = getMenuData($menu1->id);
        if($level2){//has level 2 menu
          $menu .= ' <li class="dropdown">'; //level start
          $menu .= '<a href="'.$menu_data1['siteurl'].'" '.$menu_data1['target'].'>'.$menu_data1['title'].'</a>';
          $menu .= '<ul>';//level 2 begins
          foreach($level2 as $menu2):
            $menu_data2 = getCorrectURL($menu2);
            $level3 = getMenuData($menu2->id);
            if($level3){
              $menu .= '<li class="dropdown">';
              $menu .= '<a href="'.$menu_data2['siteurl'].'" '.$menu_data2['target'].'>'.$menu_data2['title'].'</a>';
              $menu .= '<ul>'; //level 3 starts
              foreach($level3 as $menu3):
                $menu_data3 = getCorrectURL($menu3);
                $menu .= '<li><a href="'.$menu_data3['siteurl'].'" '.$menu_data3['target'].'>'.$menu_data3['title'].'</a></li>';
              endforeach;
              $menu .= '</ul>'; //level3 ends
              $menu .= '</li>';
            }else{
              $menu .= '<li><a href="'.$menu_data2['siteurl'].'" '.$menu_data2['target'].'>'.$menu_data2['title'].'</a></li>';
            }
          endforeach;
          $menu .= '</ul>';//level 2 ends
          $menu .= '</li>';//level 1 ends
        }else{ // if no child menu
          $menu .= '<li><a href="'.$menu_data1['siteurl'].'" '.$menu_data1['target'].'>'.$menu_data1['title'].'</a></li>';
        }
      endforeach;
    }
    $menu .= '</ul>';
    return $menu;
  }
}

if(!function_exists('footer_menu')){
  function footer_menu(){
    $level1 = getMenuData(0,'footer');
    $menu = '';
    if($level1){
      foreach($level1 as $menu1):
        $menu .= '<div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">';
        $menu .= '<div class="footer-widget__column footer-widget__links clearfix">';
        $level2 = getMenuData($menu1->id,'footer');
        if($level2){
          $menu .= '<h3 class="footer-widget__title">'.$menu1->title.'</h3>';
          $menu .= '<ul class="footer-widget__links-list list-unstyled clearfix">';
          foreach($level2 as $menu2):
            $menu_data2 = getCorrectURL($menu2);
            $menu .= '<li><a href="'.$menu_data2['siteurl'].'" '.$menu_data2['target'].'>'.$menu_data2['title'].'</a></li>';
          endforeach;
          $menu .= '</ul>';
        }else{
          $menu .= '<h3 class="footer-widget__title">'.$menu1->title.'</h3>';
        }
        $menu .= '</div>';
        $menu .= '</div>';
      endforeach;
    }
    return $menu;
  }
}

if(!function_exists('getMenuData')){
  function getMenuData($parent=0,$location='header'){
    return DB::table('site_menus')->where('status','active')->where('parent',$parent)->where('location',$location)->get();
  }
}

if(!function_exists('getPopUp')){
  function getPopUp(){
    return DB::table('popups')->where('status','active')
    ->where(DB::raw("STR_TO_DATE(concat(start_date,' ',start_time), '%Y-%m-%d %h:%i %p')"),'<=',date('Y-m-d H:i:s'))
    ->where(DB::raw("STR_TO_DATE(concat(end_date,' ',end_time), '%Y-%m-%d %h:%i %p')"),'>=',date('Y-m-d H:i:s'))
    ->orderBy('order_by','ASC')
    ->get();
  }
}