<?php

namespace App\Models\Admin;

use App\Models\PaymentMethod;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donner extends Model
{
    use HasFactory, Sortable;

    protected $table = 'donners';

    protected $fillable = ['email','fullName', 'number', 'amount', 'paymentMethod', 'donationProgram', 'updated_by', 'status', 'order_by', 'image','position',
    'remarks','attachment','bank_id','created_by','updated_by'];
    public $sortable = ['status', 'fullName', 'amount'];


    public static function getTotal($filter = [])
    {
        $query = Donner::where('status', '!=', 'deleted');
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('fullName', 'like', '%' . $filter['filter_search_text'] . '%')
            ->orWhere('amount','like', '%' . $filter['filter_search_text'] . '%')
            ->where('status','!=','deleted');
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = Donner::where('status', '!=', 'deleted');
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where('fullName', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->orWhere('amount', 'like', '%' . $filter['filter_search_text'] . '%');
            $query->where('status', '!=','deleted');
        }
        //filter condition ends
        $categories = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $categories;
    }


    public function getPayment() {
       return PaymentMethod::where('id',$this->paymentMethod)->orWhere('code',$this->paymentMethod)->first();
    }
}
