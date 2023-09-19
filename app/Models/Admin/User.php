<?php

namespace App\Models\Admin;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\CreatedUpdatedBy;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CreatedUpdatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'username', 'email', 'phone', 'password','remember_token', 'email_verified_at','role_id', 'status', 'created_by', 'updated_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public static function getTotal($filter = [])
    {
        $query = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.status', '!=', 'deleted')->where('users.id','!=',1);
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('users.name', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('users.phone', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('users.email', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('users.username', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('roles.name', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        $total_data = $query->count();
        return $total_data;
    }

    public static function getData($sort = [], $pagination = [], $filter = [])
    {
        $query = User::select(['users.*', 'roles.name as user_roles'])
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.status', '!=', 'deleted')->where('users.id','!=',1);
        //filter conditions begins
        if (isset($filter['filter_search_text']) && strlen(trim($filter['filter_search_text']))) {
            $query->where(function($group) use ($filter){
                $group->where('users.name', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('users.phone', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('users.email', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('users.username', 'like', '%' . $filter['filter_search_text'] . '%');
                $group->orwhere('roles.name', 'like', '%' . $filter['filter_search_text'] . '%');
            });
        }
        //filter condition ends
        $users = $query->orderby($sort['field'], $sort['position'])->offset($pagination['offset'])->limit($pagination['limit'])->get();
        return $users;
    }

    public function updateProfile($req) {
        $this->update([
            'name'=>$req['name'],
            'username'=>$req['username'],
            'email'=>$req['email'],
            'phone'=>$req['phone']
        ]);
    }

    public function getRole() {
        return Role::where('id',$this->id)->first();
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function carts() {
        return $this->hasMany(Cart::class);
    }

}
