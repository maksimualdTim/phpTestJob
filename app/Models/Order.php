<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    static public function separateFullName(string $fullname) : Array{
        return explode(' ', $fullname);
    }
}
