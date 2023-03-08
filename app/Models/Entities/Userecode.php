<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model

{
    protected $table='userecord';
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cost',
        'point',
        'orders_id',
        'date',
    ];

}
