<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\EmailTemplates;
use App\Models\Admin\Product;
use App\Models\Admin\User;
use App\Models\Cart;
use App\Models\Order;
use Toastr;
use Mail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function checkMethod(Request $req)
    {
        if (!$req->session()->has('user')) {
            return redirect()->route('customer.register');
        }
        $usr = User::where('username', $req->session()->get('user')['unm'])->first();
        $cost = 0;
        if ($req->type) {
            $cost = Cart::where('user_id', $usr->id)->sum('total');
        } else {
            $prod = Product::where('status', 'active')->where('id', $req->product)->first();
            $cost = $prod->price;
        }

        $pid = $usr->id . '-' . time() . '-' . $usr->id;
        if ($req->method == 'COD') {
            $products = '';
            if ($req->type) {
                $c = Cart::where('user_id', $usr->id)->get();
                foreach ($c as $cart) {
                    $products .= $cart->product_id . ',';
                }
            } else {
                $products = $prod->id;
            }
            $o = Order::create([
                'user_id' => $usr->id,
                'oid' => $pid,
                'products' => rtrim($products, ","),
                'payment_method' => 'COD',
                'amount' => $cost,
                'ref_id' => null,
                'status' => 'active'
            ]);

            $tbl = '<table border="1">
            <tr><th>Product</th>' . ($req->type ? '<th>Qty</th>' : '') . '<th>Price</th></tr>
        ';
            $prods = explode(',', $o->products);
            foreach ($prods as $p) {
                $pp = $o->product($p);
                $tbl .= '<tr>
            <td>' . $pp->title . '</td>' .
                    ($req->type ? '<td>' . $o->quantity($p, $o->user_id) . '</td>' : '') .
                    '<td>Rs.' . $pp->price . '</td></tr>';
            }

            $tbl .= '<tr><td colspan="100%">Method:' . $o->getMethod($o->payment_method) . '</td></tr>
        <tr><td colspan="100%">Total: Rs.' . $o->amount . '</td></tr>
        </table>';

            $replace = array(
                'status_link' => url('') . '/user/orders',
                'product' => $tbl,
            );
            $this->data['template'] = EmailTemplates::where('status', 'active')->where('template_name', 'order-response')->first();
            $msg = $this->parse_email_template($this->data['template']->user_message, $replace);

            $this->data['mail_id'] = $usr->email;
            $this->data['mail_name'] = $usr->name;
            try {
                $data = array('name' => "Bisava Technology", 'msg' => $msg);
                Mail::send('mail', $data, function ($message) {
                    $message->to($this->data['mail_id'], $this->data['mail_name'])->subject($this->data['template']->user_subject);
                    $message->from('info@bisava.tech', 'Bisava Technology');
                });
            } catch (\Throwable $th) {
                dd('something went wrong with the server');
            }

            if ($req->type) {
                Cart::where('user_id', $usr->id)->delete();
                $usr = User::where('id', $usr->id)->first();
                $req->session()->put('user', ['name' => $req->session()->get('user')['name'], 'unm' => $req->session()->get('user')['unm'], 'pic' => $req->session()->get('user')['pic'], 'cart' => $usr->carts]);
            }
            Toastr::success('Your order has been placed', 'Thank You!');
            return redirect('/');
        } else if ($req->method == 'ESW') {
            echo '
            <form action="https://uat.esewa.com.np/epay/main" method="POST" id="subForm">
                <input value="' . $cost . '" name="tAmt" type="hidden">
                <input value="' . $cost . '" name="amt" type="hidden">
                <input value="0" name="txAmt" type="hidden">
                <input value="0" name="psc" type="hidden">
                <input value="0" name="pdc" type="hidden">
                <input value="EPAYTEST" name="scd" type="hidden">
                <input value="' . $pid . '" name="pid" type="hidden">
                <input value="' . url('') . '/order/validate/' . $cost . '/' . ($req->type ? $req->type : $prod->id) . '" type="hidden" name="su">
                <input value="' . url('') . '/order/validate/' . $cost . '/' . ($req->type ? $req->type : $prod->id) . '?type=fail" type="hidden" name="fu">
                <input value="Submit" type="submit" style="display:none;">
                </form>
                <script>
                document.getElementById("subForm").submit();
                </script>
                ';
        }
    }

    public function validatePayment($cost, $type = '', Request $req)
    {
        if (isset($_GET['type'])) {
            echo '
                Your payment has failed for some reason. please contact the payment provider, Thank You,<br>
                <a href="/">Home</a>
            ';
            die();
        }
        $status = 'active';

        if ($cost != $_GET['amt']) {
            $status = 'inactive';
        }
        $products = '';
        $user = explode('-', $_GET['oid']);
        if ($type == 'cart') {
            $c = Cart::where('user_id', $user[0])->get();
            foreach ($c as $cart) {
                $products .= $cart->product_id . ',';
            }
        } else {
            $products = $type;
        }


        $o = Order::create([
            'user_id' => $user[0],
            'oid' => $_GET['oid'],
            'products' => rtrim($products, ","),
            'payment_method' => 'ESW',
            'amount' => $_GET['amt'],
            'ref_id' => $_GET['refId'],
            'status' => $status
        ]);
        if ($status == 'active') {
            $tbl = '<table border="1">
                <tr><th>Product</th>' . ($type == "cart" ? '<th>Qty</th>' : '') . '<th>Price</th></tr>
            ';
            $prods = explode(',', $o->products);
            foreach ($prods as $p) {
                $pp = $o->product($p);
                $tbl .= '<tr>
                <td>' . $pp->title . '</td>' .
                    ($type == 'cart' ? '<td>' . $o->quantity($p, $o->user_id) . '</td>' : '') .
                    '<td>Rs.' . $pp->price . '</td></tr>';
            }
            $tbl .= '<tr><td colspan="100%">Method:' . $o->getMethod($o->payment_method) . '</td></tr>
            <tr><td colspan="100%">Total: Rs.' . $o->amount . '</td></tr>
            </table>';

            $replace = array(
                'status_link' => url('') . '/user/orders',
                'product' => $tbl,
            );
            $this->data['template'] = EmailTemplates::where('status', 'active')->where('template_name', 'order-response')->first();
            $msg = $this->parse_email_template($this->data['template']->user_message, $replace);

            $this->data['mail_id'] = User::where('id', $user[0])->first()->email;
            $this->data['mail_name'] = User::where('id', $user[0])->first()->name;
            try {
                $data = array('name' => "Bisava Technology", 'msg' => $msg);
                Mail::send('mail', $data, function ($message) {
                    $message->to($this->data['mail_id'], $this->data['mail_name'])->subject($this->data['template']->user_subject);
                    $message->from('info@bisava.tech', 'Bisava Technology');
                });
            } catch (\Throwable $th) {
                dd('something went wrong with the server');
            }

            if ($type == 'cart') {
                Cart::where('user_id', $user[0])->delete();
                $usr = User::where('id', $user[0])->first();
                $req->session()->put('user', ['name' => $req->session()->get('user')['name'], 'unm' => $req->session()->get('user')['unm'], 'pic' => $req->session()->get('user')['pic'], 'cart' => $usr->carts]);
            }
            Toastr::success('Your order has been placed', 'Thank You!');
        } else {
            Toastr::error('Something went wrong with your payment', 'Invalid');
        }
        return redirect('/');
    }
}
