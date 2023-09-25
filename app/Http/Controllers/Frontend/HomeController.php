<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Album;
use App\Models\Admin\Banner;
use App\Models\Admin\Blog;
use App\Models\Admin\CounterInformation;
use App\Models\Admin\Discount;
use App\Models\Admin\HomeSetting;
use App\Models\Admin\Page;
use App\Models\Admin\Product;
use App\Models\Admin\Program;
use App\Models\Admin\Service;
use App\Models\Admin\Supporter;
use App\Models\Admin\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    public function index(Request $req) {

        $this->siteStatus();
        // dd($req->session()->get('user'));
        $this->data['is_home']      = true;
        $this->data['homeSetting']  = HomeSetting::first();
                
        $meta = get_meta_detail($this->data['siteSetting']);
        return view('Frontend.pages.home', $this->data+$meta);
    }

    

}
