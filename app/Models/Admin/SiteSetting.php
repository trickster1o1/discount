<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table = 'site_settings';

    protected $fillable = ['title', 'email',
    'created_by','updated_by',
    'pri_phone', 'pri_email', 'pri_address', 'sec_phone', 'sec_email', 'sec_address', 'email_verification', 'primary_logo', 'secondary_logo', 'url', 'offline_msg', 'fb_link', 'youtube_link', 'twitter_link', 'ig_link', 'linkedin_link', 'viber', 'pintrest_link', 'skype_link', 'facebook_page_id', 'android', 'ios', 'meta_key', 'meta_description', 'fb_title', 'fb_image', 'fb_description', 'twitter_title', 'twitter_description', 'twitter_image', 'status','google_map_html','loader'];
}
