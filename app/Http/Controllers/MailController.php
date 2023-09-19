<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Controller;
use Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    //
    public function basic_email()
    {
        $data = array('name' => "Bisava Technology");

        Mail::send(['text' => 'mail'], $data, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel Basic Testing Mail');
            $message->from('xyz@gmail.com', 'Bisava Technology');
        });
        echo "Basic Email Sent. Check your inbox.";
    }
    public function html_email()
    {
        $data = array('name' => "Bisava Technology");
        Mail::send('mail', $data, function ($message) {
            $message->to('nischaltuladhar15@gmail.com', 'Nischal Tuladhar')->subject('Laravel HTML Testing Mail');
            $message->from('info@bisava.tech', 'Bisava Technology');
        });
        echo "HTML Email Sent. Check your inbox.";
    }
    public function attachment_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send('mail', $data, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel Testing Mail with Attachment');
            $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
            $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        echo "Email Sent with attachment. Check your inbox.";
    }
}
