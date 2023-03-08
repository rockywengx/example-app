<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model

{
    protected $table='users';
    use HasFactory;
    protected $fillable = [
        'name',
        'username',
        'password',
        'phone',
        'address',
        'birthday',
        'telephone',
        'status_id',
        'customer_source_id',
        'point',
        'mail',
        'certificate',

        'user_id',
        'accumulated_points',
        'redeemed_points',
        'first_sale',
        'last_sale',

        'sex',
        'line',
        'card',
        'company_telephone',
        'login_branch'
    ];
    // public function Customer_source()
    // {
    //     return $this->belongsTo('App\Models\Entities\Customer_source','customer_source_id','id');
    // }
    // public function Scope()
    // {
    //     return $this->belongsTo('App\Models\Entities\Scope','status_id','id');
    // }
    // public function Discount()
    // {
    //     return $this->belongsToMany('App\Models\Entities\Discount');
    // }
    // public function Orders()
    // {
    //     return $this->hasMany('App\Models\Entities\Orders');
    // }
    // public function branch()
    // {
    //     return $this->belongsTo('App\Models\Entities\Branch','login_branch','branch_id');
    // }
}
