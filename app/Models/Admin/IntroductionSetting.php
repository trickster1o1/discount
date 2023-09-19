<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntroductionSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'banner_image','thumb_image','description','title','banner_title','tagline',
        'tabA_content','tabB_content','tabC_content',
        'supporter','testimonials',
        'created_by','updated_by',
        'second_banner_image','second_banner_title','second_banner_tagline','second_banner_button_title',
        'second_banner_button_link','volunteer','volunteer_title','volunteer_tagline','testimonial_title','testimonial_tagline'
    ];
}
