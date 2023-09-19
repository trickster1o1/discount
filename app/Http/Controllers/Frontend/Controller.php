<?php

namespace App\Http\Controllers\Frontend;

use App\Mail\Email;
use App\Models\Admin\EmailTemplates;
use App\Models\Admin\InternalLinks;
use App\Models\Admin\Product;
use App\Models\Admin\SiteMenu;
use App\Models\Admin\SiteSetting;
use App\Models\Admin\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

//use Illuminate\Support\Facades\Mail;
class Controller extends BaseController
{
    public $data;
    public $siteSetting;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     function __construct()
    {
        // define('DEFAULT_IMAGE_PATH','uploads/defaults/');
        $this->data['defaults'] = '/uploads/defaults/';
        $this->siteSetting = SiteSetting::first();
        // $this->data['main_menu']    = main_menu();
        $this->data['main_menu']    = SiteMenu::where('status','active')->where('location','header')->get();
        $this->data['footer_menu']  = SiteMenu::where('status','active')->where('location','footer')->get();
        // $this->data['f_about'] = InternalLinks::where('status','active')->where('slug','about-the-founder')->first()->short_description;
        $this->data['f_prod'] = Product::where('status','active')->orderBy('id','DESC')->take(4)->get();
        $this->data['popup_messages']= getPopUp();
        $this->data['siteSetting']  = $this->siteSetting;
        /*if($this->siteSetting){
            if(strtolower($this->siteSetting->active_status) == 'offline'){
                //loads offline message
            }
        }else{  
            //loads configuration message
        }*/

            $this->data['shareButtons1'] = \Share::page(
                \URL::current()
            )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp() 
            ->reddit();
    }
    //site status 
    public function siteStatus() {
        if(!Auth()->user()){

            if(!$this->siteSetting || $this->siteSetting['status'] == 'offline') {
                $msg = $this->siteSetting['offline_msg'] ? $this->siteSetting['offline_msg'] : 'The site is currently in maintainance.';
                echo "
                    <html>
                        <head><title>Maintainance</title>
                        <style>
                            body {
                                display:flex;
                                height:97vh;
                                width:97vw;
                                justify-content:center;
                                align-items:center;
                            } div {
                                display:flex;
                                flex-direction:column;
                                justify-content:center;
                                align-items:center;
                                border:1px solid rgba(0,0,0,.4);
                                height:25vh;width:75vw;
                                overflow:auto;
                            }

                        </style>
                        </head>
                        <body>
                            <div>
                                <h1>Sorry!</h1>
                                <h3>".$msg."</h3>
                            </div>
                        </body>
                    </html>

                ";
                die();
                
            }
        }
    }

    //email setups.................
    public function parse_email_template($raw_template, $replace) {
        $pattern = '{{%s}}';
        $map = array();
        if ($replace) {
            foreach ($replace as $var => $value) {
                $map[sprintf($pattern, $var)] = $value;
            }
            $template = strtr($raw_template, $map);
        }
        return $template;
    }
    /*
        template = template name stored in database
        userParams = ['user_replace'=>array(use replaces params),'to_name'=>'fullname','to_email'=>'userEmail']
        adminReplace = array(replacing parameteres only)
        type -- single/bluk - for multiple recipient send email as group in bluk or send individually
    */
    function mailSender($template='',$userParams='',$adminReplace='',$admin_email_type='bluk') {  
        $template = EmailTemplates::where('template_name',$template)->where('status','=','active')->get()->first();
        if($template){//if template exists only
            $params['from_email'] = $this->siteSetting->email;
            $params['from_name']  = $this->siteSetting->title;
            //Email Setup for User
            if(!empty(trim($template->user_subject)) && is_array($userParams)){
                $user_message = $this->parse_email_template($template->user_message,$userParams['user_replace']);
                $params['to_email']   = $userParams['to_email'];
                $params['to_name']	  = $userParams['to_name'];
                $params['subject']	  = $template->user_subject;
                $params['message']	  = $user_message;
                return sendWithPhpMailer($params);

            }
            //Email Setup for Admin
            if((!empty(trim($template->custom_email)) || !empty(trim($template->admin_user))) && !empty(trim($template->admin_subject))){
                $admin_emails  = explode(',',$template->custom_email);
                $admin_ids = explode(',',$template->admin_user);
                if(count($admin_ids) >0){
                    $users = \DB::table('users')->select('email')->where('status','=','active')->whereIn('id',$admin_ids)->get();
                    if($users){
                        foreach($users as $user):
                            array_push($admin_emails,$user->email);
                        endforeach;
                    }
                    $admin_message = $this->parse_email_template($template->admin_message,$adminReplace);
                    $params['subject'] = $template->admin_subject;
                    $params['message'] = $admin_message;
                    if(count($admin_emails) > 0){
                        if($admin_email_type == 'single'){
                            foreach($admin_emails as $admin_email)://send email to multiple address individually
                                $params['to_email'] = $admin_email;
                                sendWithPhpMailer($params);
                            endforeach;
                        }else{
                            sendWithPhpMailer($params,$admin_emails);//send email to multiple address bluck
                        }
                    }
                }
                return 'admin thik';
            }
            return true;
        }else{
            return false;
        }
    }

}