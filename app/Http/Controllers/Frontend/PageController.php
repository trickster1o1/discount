<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\VolunteerFormRequest;
use App\Models\Admin\Category;
use App\Models\Admin\InternalLinks;
use App\Models\Admin\Product;
use App\Models\Admin\Volunteer;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    // Dynamic link fetch functions -------------------------------

    function getLink($link)
    {
        $this->siteStatus();
        // if($link) {
        //     $link = ucfirst($link);
        // }
        // $model = 'App\Models\Admin\\'.$link;

        try {
            // $this->data['defaults'] = DEFAULT_IMAGE_PATH;
            // if(strtolower($link) == 'volunteer'){
            //     $this->data['page'] = $model::where('status','active')->where('accepted','yes')->orderBy('order_by','ASC')->paginate(30);
            // }else{
            //     $this->data['page'] = $model::where('status','active')->orderBy('order_by','ASC')->paginate(30);
            // }
            $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', strtolower($link))->first();

            if (!$this->data['linkData']) {
                $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'error404')->first();
                return view('Frontend.error.error404', $this->data);
            }
            $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);

            return view(
                'Frontend.page.page',
                $this->data + $meta
            );
        } catch (\Throwable $th) {
            $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'error404')->first();
            return view('Frontend.error.error404', $this->data);
        }
    }

    function thematicDetail($slug)
    {
        $this->siteStatus();
        $model = 'App\Models\Admin\Program';

        try {
            // $this->data['defaults'] = DEFAULT_IMAGE_PATH;
            $cat = \App\Models\Admin\Category::where('slug', $slug)->first();
            if (!$cat) {
                $this->data['page'] = [];
            } else {
                $this->data['page'] = $model::where('status', 'active')->where('category', $cat->id)->orderBy('order_by', 'ASC')->paginate(30);
            }

            $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'program')->first();
            $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);

            return view(
                'Frontend.page.cfilter.Program',
                $this->data + $meta
            );
        } catch (\Throwable $th) {
            $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'error404')->first();
            return view('Frontend.error.error404', $this->data);
        }
    }

    function getDetail($link, $slug)
    {
        //get sites online offline status
        $this->siteStatus();

        if ($link) {
            $link = ucfirst($link);
        }
        $model = 'App\Models\Admin\\' . $link;
        $this->data['comments'] = null;
        $this->data['category_title'] = null;
        try {
            if (strtolower($link) == 'album') {
                $album = $model::where('status', 'active')->where('slug', $slug)->first();
                $this->data['detail'] = $album;
                if ($album) {
                    $album_id = $album->id;
                    $galleries = \DB::table('galleries')->where('album_id', $album_id)->orderBy('order_by', 'ASC')->get();
                    $this->data['galleries'] = $galleries;
                } else {
                    $this->data['detail'] = false;
                    $this->data['galleries'] = false;
                }
            } else {
                $this->data['detail'] = $model::where('status', 'active')->where('slug', $slug)->first();
            }

            if ($this->data['detail'] && isset($this->data['detail']->comments)) {
                $this->data['comments'] = $this->data['detail']->comments()->where('status', 'active')->orderBy('created_at', 'desc')->take(4)->get();
            }


            if ($this->data['detail']) {
                if (isset($this->data['detail']->category)) {
                    $category  = \DB::table('categories')->select('title')->where('id', $this->data['detail']->category)->first();
                    $this->data['category_title'] = $category->title;
                }
                $meta = get_meta_detail($this->data['siteSetting'], $this->data['detail']);
                return view(
                    'Frontend.page.detail.' . $link,
                    $this->data + $meta
                );
            } else {
                $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'error404')->first();
                $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);
                return view('Frontend.error.error404', $this->data + $meta);
            }
        } catch (\Throwable $th) {
            $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'error404')->first();
            $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);
            return view('Frontend.error.error404', $this->data + $meta);
        }
    }

    function getProduct($slug = null)
    {
        $this->siteStatus();
        if ($slug) {
            $c = Category::where('status', 'active')->where('slug', $slug)->first();
            if (!$c) {
                $this->data['products'] = [];
                return view('Frontend.page.product', $this->data);
            }
            $this->data['cTitle'] = $c->title;
            $this->data['products'] = Product::where('status', 'active')->where('category', $c->id)->orderBy('order_by', 'ASC')->get();
        } else {
            $this->data['products'] = Product::where('status', 'active')->orderBy('order_by', 'ASC')->get();
        }
        $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'product')->first();
        $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);
        return view('Frontend.page.product', $this->data);
    }


    function getProdDetail($slug)
    {
        //get sites online offline status
        $this->siteStatus();

        try {
            $this->data['product'] = Product::where('status', 'active')->where('slug', $slug)->first();
            $this->data['methods'] = PaymentMethod::where('status','active')->get();
            $this->data['average'] = DB::table('reviews')->where('status','!=','deleted')->where('product_id',$this->data['product']->id)->avg('rating');
            $this->data['similar_prod'] = Product::where('status', 'active')->where('category', $this->data['product']->category)->where('slug', '!=', $slug)->take(4)->get();
            $this->data['linkData'] = $this->data['product'];
            $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);
            return view('Frontend.page.detail.product', $this->data + $meta);
        } catch (\Throwable $th) {
            $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'error404')->first();
            $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);
            return view('Frontend.error.error404', $this->data + $meta);
        }
    }

    function getGallery()
    {
        $this->data['galleries'] = Product::where('status', 'active')->get(['slug', 'title', 'thumb_image']);
        $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'gallery')->first();
        $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);

        return view('Frontend.page.gallery', $this->data);
    }

    function getAbout()
    {
        $this->siteStatus();

        $this->data['page'] = \App\Models\Admin\IntroductionSetting::first();
        $this->data['supporters'] = [];
        $this->data['testimonials'] = [];
        $this->data['volunteers'] = [];
        $this->data['tabs'] = [];
        if ($this->data['page'] && $this->data['page']->supporter) {
            $this->data['supporters'] = \App\Models\Admin\Supporter::where('status', 'active')->orderBy('order_by', 'desc')->get();
        }
        if ($this->data['page'] && $this->data['page']->testimonials) {
            $this->data['testimonials'] = \App\Models\Admin\Testimonials::where('status', 'active')->orderBy('id', 'desc')->get();
        }

        if ($this->data['page'] && $this->data['page']->volunteer) {
            $this->data['volunteers'] = \App\Models\Admin\Volunteer::where('status', 'active')->orderBy('order_by', 'ASC')->take(4)->get();
        }

        if ($this->data['page']) {
            if ($this->data['page']->tabA_content) {
                $tab = \App\Models\Admin\Page::where('id', $this->data['page']->tabA_content)->first();
                array_push($this->data['tabs'], $tab);
            }
            if ($this->data['page']->tabB_content) {
                $tab = \App\Models\Admin\Page::where('id', $this->data['page']->tabB_content)->first();
                array_push($this->data['tabs'], $tab);
            }
            if ($this->data['page']->tabC_content) {
                $tab = \App\Models\Admin\Page::where('id', $this->data['page']->tabC_content)->first();
                array_push($this->data['tabs'], $tab);
            }
        }

        $this->data['linkData'] = InternalLinks::where('status', 'active')->whereIn('slug', array('about', 'introduction'))->first();
        $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);

        return view(
            'Frontend.page.introduction',
            $this->data + $meta
        );
    }
    // Related services --------------------
    function relatedService($id)
    {
        $services = \App\Models\Admin\Service::where('id', '!=', $id)->where('status', 'active')->take(5)->get();
        if (count($services)) {
            return ['msg' => 'success', 'services' => $services];
        }

        return ['msg' => 'empty'];
    }
    //latest blog post ---------------------

    function getLatestBlogs()
    {
        $blogs = \App\Models\Admin\BLog::where('status', 'active')->orderBy('publish_date', 'desc')->take(3)->get();
        if (count($blogs)) {
            return ['msg' => 'success', 'blogs' => $blogs];
        }
        return ['msg' => 'empty'];
    }

    function getRelatedBlogs($tags, $id)
    {
        $condition = [];
        if ($tags) {
            $tags = explode(',', $tags);
        }
        $blogs = \App\Models\Admin\BLog::where('status', 'active')->where('id', '!=', $id)->whereRaw("find_in_set('" . $tags[0] . "',tags)")->orderBy('publish_date', 'desc')->take(3)->get();
        if (count($blogs)) {
            return ['msg' => 'success', 'blogs' => $blogs];
        }
        return ['msg' => 'empty'];
    }

    function getBlogCat()
    {
        $cats = \App\Models\Admin\Category::where('status', 'active')->where('category_type', 'blog')->take(5)->get();
        if (count($cats)) {
            return ['msg' => 'success', 'cats' => $cats];
        }
        return ['msg' => 'empty'];
    }

    //latest programms ------------------------
    function getLatestProg()
    {
        $progs = \App\Models\Admin\Program::where('status', 'active')->orderBy('created_at', 'desc')->take(5)->get();
        if (count($progs)) {
            return ['msg' => 'success', 'prog' => $progs];
        }
        return ['msg' => 'empty'];
    }

    //Become a volunteer -------------------

    function volunteerForm()
    {
        $this->siteStatus();

        $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'become-a-volunteer')->first();
        $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);

        return view(
            'Frontend.page.BecomeAVolunteer',
            $this->data + $meta
        );
    }

    function submitVolunteerForm(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'fullName' => 'required|min:2|max:255|regex:/^([^0-9]*)$/',
            'email' => 'required|email',
            'number' => 'required|numeric',
            'message' => 'required',
            'address' => 'required',
            'occupation' => 'required',
            'dob' => 'nullable'
        ]);

        if ($validator->fails()) {
            return array('msg' => 'error', 'message' => 'Validation Error!!!', 'errors' => $validator->errors()->messages());
        } else {
            Volunteer::create($req->input());

            $message = '
            <table>
                <tr>
                    <td><b>Name: </b></td>
                    <td>' . $req->fullName . '</td>
                </tr>
                <tr>
                    <td><b>Email: </b></td>
                    <td>' . $req->email . '</td>
                </tr>
                <tr>
                    <td><b>Number: </b></td>
                    <td>' . $req->number . '</td>
                </tr>
                <tr>
                    <td><b>Occupation: </b></td>
                    <td>' . $req->occupation . '</td>
                </tr>
                <tr>
                    <td><b>Message: </b></td>
                    <td>' . $req->message . '</td>
                </tr>
            </table>
        ';
            $replace = array(
                'message' => $message,
                'site_title' => $this->siteSetting->title,
                'site_link' => url(''),
            );
            $this->mailSender('become-a-volunteer', '', $replace);
            return ['msg' => 'success', 'message' => 'Your message has been submitted successfully!', 'errors' => ''];
        }
    }

    //Contact us control-----------------------------------

    function contactUsForm()
    {
        $this->siteStatus();

        $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'contact-us')->first();
        $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);
        return view(
            'Frontend.page.contactsForm',
            $this->data + $meta
        );
    }

    function submitContactForm(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'fullName' => 'required|min:2|max:255|regex:/^([^0-9]*)$/',
            'email' => 'required|email',
            'number' => 'required|numeric',
            'subject' => 'required|max:150',
            'message' => 'required|max:500',
        ]);

        if ($validator->fails()) {
            return array('msg' => 'error', 'message' => 'Validation Error! Please check and try again.', 'errors' => $validator->errors()->messages());
        } else {

            \App\Models\Admin\Contact::create($req->input());


            $message = '
                <table>
                    <tr>
                        <td><b>Name: </b></td>
                        <td>' . $req->fullName . '</td>
                    </tr>
                    <tr>
                        <td><b>Email: </b></td>
                        <td>' . $req->email . '</td>
                    </tr>
                    <tr>
                        <td><b>Number: </b></td>
                        <td>' . $req->number . '</td>
                    </tr>
                    <tr>
                        <td><b>Subject: </b></td>
                        <td>' . $req->subject . '</td>
                    </tr>
                    <tr>
                        <td><b>Message: </b></td>
                        <td>' . $req->message . '</td>
                    </tr>
                </table>
            ';
            $replace = array(
                'message' => $message,
                'site_title' => $this->siteSetting->title,
                'site_link' => url(''),
            );
            $this->mailSender('contact-us', '', $replace);

            return ['msg' => 'success', 'message' => 'Your message has been submitted successfully!', 'errors' => ''];
        }
    }
    // comment publish controll 
    function publishComment($model, Request $req)
    {

        $validator = Validator::make($req->all(), [
            'name' => 'required|min:2|max:255|regex:/^([^0-9]*)$/',
            'email' => 'required|email',
            'comment' => 'required'
        ]);
        if ($validator->fails()) {
            return ['msg' => 'error', 'message' => 'Some validation problem found!!!', 'error' => $validator->errors()->messages()];
        }
        try {
            $model = explode(',', $model);
            $table = 'App\Models\Admin\\' . $model[0];
            $table = $table::where('status', 'active')->where('id', $model[1])->first();
            $table->comments()->create($req->input());

            return ['msg' => 'success', 'message' => 'Review submitted successfully!!!'];
        } catch (\Throwable $th) {
            return ['msg' => 'error', 'message' => 'Some validation problem found!!!'];
        }
    }

    function getDonnerForm($id = '0')
    {
        $this->siteStatus();

        $this->data['selected_slug'] = $id;
        $this->data['programs'] = \App\Models\Admin\Program::where('status', 'active')->get();
        $this->data['banks'] = \App\Models\Admin\BankDetail::where('status', 'active')->orderBy('order_by', 'ASC')->get();
        $this->data['paymentSetting'] = \App\Models\Admin\PaymentSettings::first();
        $this->data['payments'] = \App\Models\PaymentMethod::where('status', 'active')->get();

        $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'donate-now')->first();
        $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);
        return view(
            'Frontend.page.donnerForm',
            $this->data + $meta
        );
    }
    function submitDonnerForm(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'fullName' => 'required|min:2|max:255|regex:/^([^0-9]*)$/',
            'email' => 'required|email',
            'number' => 'required|numeric',
            'paymentMethod' => 'required',
            'donationProgram' => 'nullable',
            'amount' => 'required|numeric|min:10'
        ]);

        if ($validator->fails()) {
            return array('msg' => 'error', 'message' => 'Validation Error!!!', 'errors' => $validator->errors()->messages());
        }

        $donnerId = \App\Models\Admin\Donner::create($req->input());

        $donnerId->update(['status' => 'pending']);

        $donation_title = '';
        if ($req->donationProgram && strlen(trim($req->donationProgram))) {
            $donation_query = \DB::table('programs')->where('id', $req->donationProgram)->first();
            if ($donation_query) {
                $donation_title = '<tr><td><b>Program:</b></td><td>' . $donation_query->title . '</td></tr>';
            }
        }

        $payment_title = '';

        if ($req->paymentMethod && strlen(trim($req->paymentMethod))) {
            $query = \DB::table('payment_methods')->where('code', $req->donationProgram)->first();
            if ($query) {
                $payment_title = '<tr><td><b>Program:</b></td><td>' . $query->method . '</td></tr>';
            }
        }

        $message = '
                <table>
                    <tr>
                        <td><b>Name: </b></td>
                        <td>' . $req->fullName . '</td>
                    </tr>
                    <tr>
                        <td><b>Email: </b></td>
                        <td>' . $req->email . '</td>
                    </tr>
                    <tr>
                        <td><b>Number: </b></td>
                        <td>' . $req->number . '</td>
                    </tr>
                    <tr>
                        <td><b>Subject: </b></td>
                        <td>' . $req->address . '</td>
                    </tr>
                    <tr>
                        <td><b>Message: </b></td>
                        <td>' . $req->position . '</td>
                    </tr>
                    ' . $donation_title . '
                    <tr>
                        <td><b>Donnation Amount: </b></td>
                        <td>' . $req->amount . '</td>
                    </tr>
                    ' . $payment_title . '
                </table>
            ';

        $replace = array(
            'message' => $message,
            'site_title' => $this->siteSetting->title,
            'site_link' => url(''),
        );
        $this->mailSender('donation-email', '', $replace);
        return ['msg' => 'success', 'message' => 'Your Form Has Been Submitted Succesfully.', 'donner_id' => $donnerId->id, 'amount' => $req->amount, 'method' => $req->paymentMethod, 'base_url' => url('')];
    }

    function paymentMsg($type)
    {
        if ($type === 'success') {
            $url = "https://uat.esewa.com.np/epay/transrec";
            $refid = ($_GET['refId']) ? $_GET['refId'] : 0;
            $request_id = ($_GET['oid']) ? $_GET['oid'] : 0;
            $doner = \DB::table('donners')->where('id', $request_id)->first();
            $doner_id = ($doner) ? $doner->id : 0;
            $doner_amount = ($doner) ? $doner->amount : 0;
            $data = [
                'amt' => $doner_amount,
                'rid' => $refid,
                'pid' => $doner_id,
                'scd' => 'EPAYTEST'
            ];
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); //remove if not necessary
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //remove if not necessary
            $response = curl_exec($curl);
            curl_close($curl);
            $check_response = $this->get_xml_node_value('response_code', $response);

            if (strtolower($check_response) == 'success') {
                $status = 'active';
                $this->data['message'] = 'Thank You For Making Donation Through ESEWA.';
            } else {
                $status = 'failed';
                $this->data['message'] = 'Donation Through ESEWA Has Been Failed. Please Try Another Method or Try Again!!!';
            }
            $donner = \App\Models\Admin\Donner::where('id', $doner_id)->first();
            return view('Frontend.page.esewa_message', $this->data);
            $donner->update(['status' => $status, 'refid' => $refid]);
        } else {
            $donner = \App\Models\Admin\Donner::where('id', $_GET['pid'])->first();
            $donner->update(['status' => 'failed']);
            $this->data['message'] = 'Donation Through ESEWA Has Been Failed. Please Try Another Method or Try Again!!!';
            return view('Frontend.page.esewa_message', $this->data);
        }
    }

    public function get_xml_node_value($node, $xml)
    {
        if ($xml == false) {
            return false;
        }
        $found = preg_match('#<' . $node . '(?:\s+[^>]+)?>(.*?)' .
            '</' . $node . '>#s', $xml, $matches);
        if ($found != false) {

            return trim($matches[1]);
        }

        return false;
    }
    public function searchDB(Request $request)
    {
        $search = '%' . $request->srch . '%';
        $result = [];
        $db = ['blogs', 'programs', 'events'];
        foreach ($db as $d) {
            $r = DB::select('select * from ' . $d . '
            where title LIKE "' . $search . '"
            or description LIKE "' . $search . '"
            and status = "active" ');
            if (count($r)) {
                $result = $result + [$d => $r];
            }
        }

        $r = DB::select('select question as title, answer from faqs
            where question LIKE "' . $search . '"
            or answer LIKE "' . $search . '"
            and status = "active"
        ');
        if (count($r)) {
            $result = $result + ['faqs' => $r];
        }

        $this->data['linkData'] = InternalLinks::where('status', 'active')->where('slug', 'search')->first();
        $meta = get_meta_detail($this->data['siteSetting'], $this->data['linkData']);
        return view(
            'Frontend.page.search',
            compact('result') + $this->data + $meta
        );
    }
}
