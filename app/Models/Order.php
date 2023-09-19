<?php

namespace App\Models;

use App\Models\Admin\Product;
use App\Models\Admin\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'oid','products', 'payment_method', 'amount', 'ref_id', 'status',
    ];

    public $sortable  = ['title', 'user_id', 'price', 'status'];



    public static function getTotal($filter = [])
    {
        $query = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function ($group) use ($filter) {
                $group->where('orders.oid', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->where('orders.payment_method', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->where('orders.amount', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->where('orders.ref_id', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('users.name', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Order::select(['orders.*', 'users.name as user_name'])
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function ($group) use ($filter) {
                $group->where('orders.oid', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->where('orders.payment_method', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->where('orders.amount', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->where('orders.ref_id', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orWhere('users.name', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $orders = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $orders;
    }

    public function getMethod($code) {
        if(!PaymentMethod::where('code',$code)->first()) {
            return 'Cash On Delivery';
        }
        return PaymentMethod::where('code',$code)->first()->method;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product($id) {
        return Product::where('id',$id)->first();
    }
    public function quantity($prod, $uid) {
        return Cart::where('product_id',$prod)->where('user_id',$uid)->first()->quantity;
    }
}
