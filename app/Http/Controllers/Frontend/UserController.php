<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Frontend\Controller;
use App\Models\Admin\EmailTemplates;
use App\Models\Admin\Product;
use App\Models\Admin\SmtpSetting;
use App\Models\Admin\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Toastr;
use Mail;


class UserController extends Controller
{
    //

    function register(Request $req)
    {
        $this->siteStatus();
        if ($req->session()->has('user')) {
            return redirect('/');
        }
        return view('Frontend.page.register.login', $this->data);
    }
    public function customerLogin(Request $req)
    {
        if (!isset($_GET['fun'])) {
            return redirect()->route('customer.register');
        }
        $user = User::where('username', $req->username)->first();
        if ($_GET['fun'] == 'login') {
            if (!$user) {
                if ($req->page) {
                    return ['msg' => 'Invalid Cardentials'];
                }
                Toastr::error('Warning!!', 'Invalid Cardentials');
                return redirect()->route('customer.register')->with('msg', 'Invalid Cardantials')->withInput();
            }
            if (!$user->email_verified_at) {

                if ($req->page) {
                    return ['msg' => 'Email not verified'];
                }
                Toastr::error('Warning!!', 'Email not verified');
                return redirect()->route('customer.register')->with('msg', 'Invalid Cardantials')->withInput();
            }
            if (!Hash::check($req->password, $user->password)) {
                if ($req->page) {
                    return ['msg' => 'Invalid Cardentials'];
                }
                Toastr::error('Warning!!', 'Invalid Cardentials');
                return redirect()->route('customer.register')->with('msg', 'Invalid Cardantials')->withInput();
            }

            $req->session()->put('user', ['name' => $user->name, 'unm' => $user->username, 'pic' => $user->pic, 'cart' => $user->carts]);
            if ($req->page) {
                return ['msg' => 'success'];
            }
            Toastr::success('Login Success!!!', 'Logged In');
            return redirect('/');
        }
        $req->validate([
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'name' => 'required',
        ]);
        $flag = 0;
        $errors = [
            'unmE' => '',
            'emailE' => '',
            'cpwd' => '',
        ];
        if ($user) {
            $flag = 1;
            $errors['unmE'] = 'Username is already taken';
        }
        $email = User::where('email', $req->email)->first();
        if ($email) {
            $flag = 1;
            $errors['emailE'] = 'Email already exist';
        }
        if ($req->password != $req->cpwd) {
            $flag = 1;
            $errors['cpwd'] = 'Passwords doesn\'t match';
        }
        if ($flag == 1) {
            return redirect()->route('customer.register', 'user=1')->with('ers', $errors)->withInput();
        }

        $this->data['mail_id'] = $req->email;
        $this->data['mail_name'] = $req->name;
        $usr = User::create($req->input() + ['role_id' => 5]);
        $code =  sha1($usr->id . '' . time());
        $usr->update([
            'remember_token' => $code
        ]);

        $replace = array(
            'link' => url('') . '/user/' . $code . '/validate',
            'site_title' => $this->siteSetting->title,
            'site_link' => url(''),
        );
        $template = EmailTemplates::where('status', 'active')->where('template_name', 'register-email')->first();
        $msg = $this->parse_email_template($template->user_message, $replace);
        try {
            $data = array('name' => "Bisava Technology", 'msg' => $msg);
            Mail::send('mail', $data, function ($message) {
                $message->to($this->data['mail_id'], $this->data['mail_name'])->subject('Thank you for registering');
                $message->from('info@bisava.tech', 'Bisava Technology');
            });
        } catch (\Throwable $th) {
            dd('something went wrong with the server');
        }
        Toastr::success('Check Email For Validation.', 'Registered');
        return redirect()->route('customer.register');
    }

    public function validateToken($token)
    {
        $usr = User::where('remember_token', $token)->first();
        try {
            $usr->update([
                'remember_token' => null,
                'email_verified_at' => date('Y-m-d h:m:s')
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('customer.register');
        }

        Toastr::success('Email Verified! ', 'Valied');
        return redirect()->route('customer.register');
    }

    public function cart(Request $req)
    {
        if (!$req->session()->has('user')) {
            return redirect()->route('customer.register');
        }
        $this->data['user'] = User::where('username', $req->session()->get('user')['unm'])->first();
        $this->data['sub_total'] = Cart::where('user_id', $this->data['user']->id)->sum('total');

        $this->data['total_qty'] = Cart::where('user_id', $this->data['user']->id)->sum('quantity');
        $this->data['methods'] = PaymentMethod::where('status', 'active')->get();
        return view('Frontend.page.customer.cart', $this->data);
    }

    public function addCart(Request $req)
    {
        if (!$req->session()->has('user')) {
            return ['msg' => 'error', 'msg' => 'not logged in'];
        }
        $usr = User::where('username', $req->session()->get('user')['unm'])->first();
        $product = Product::where('id', $req->product)->first();
        $qty = Cart::where('user_id', $usr->id)->where('product_id', $product->id)->first();
        if ($qty) {
            $qty->update([
                'quantity' => (int)$qty->quantity + 1,
                'total' => (int)$qty->total + (int)$product->price,
            ]);
            return ['msg' => 'success', 'action' => 'Increased Quantity'];
        }
        $usr->carts()->create([
            'product_id' => $req->product,
            'quantity' => '1',
            'total' => $product->price,
        ]);
        $cart = count($usr->carts);
        $req->session()->put('user', ['name' => $usr->name, 'unm' => $usr->username, 'pic' => $usr->pic, 'cart' => $usr->carts]);
        return ['msg' => 'success', 'action' => 'Added To Cart', 'cart' => $cart];
    }

    public function rmvCart(Request $req)
    {
        $cart = Cart::where('id', $req->cart)->first();
        $cart->delete();
        $usr = User::where('username', $req->session()->get('user')['unm'])->first();
        $req->session()->put('user', ['name' => $usr->name, 'unm' => $usr->username, 'pic' => $usr->pic, 'cart' => $usr->carts]);
        $sub_total = Cart::where('user_id', $usr->id)->sum('total');
        $total_qty = Cart::where('user_id', $usr->id)->sum('quantity');

        return ['msg' => 'success', 'action' => 'Cart has been deleted', 'cart' => $usr->carts ? count($usr->carts) : 0, 'sub_total' => $sub_total, 'total_qty' => $total_qty];
    }
    public function clearCart($id, Request $req)
    {
        if (count(Cart::where('user_id', $id)->get())) {
            Cart::where('user_id', $id)->delete();
        }
        $req->session()->put('user', ['name' => $req->session()->get('user')['name'], 'unm' => $req->session()->get('user')['unm'], 'pic' => $req->session()->get('user')['pic'], 'cart' => []]);
        Toastr::success('Success', 'Cart has been cleared!');
        return redirect()->back();
    }
    public function getProfile(Request $req)
    {
        if (!$req->session()->has('user')) {
            return redirect()->route('customer.register');
        }
        $usr = User::where('username', $req->session()->get('user')['unm'])->first();
        $this->data['orders'] = Order::where('user_id', $usr->id)->paginate(10);
        return view('Frontend.page.customer.profile', $this->data);
    }
    public function orderDetail($id)
    {
        dd($id);
    }
    public function logout(Request $req)
    {
        $req->session()->forget('user');
        return redirect('/');
    }
}
