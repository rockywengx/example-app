<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Book
 *
 */
class Book extends Model
{

    protected $table='books';
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'another',
        'price'
    ];
}