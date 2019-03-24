<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    // type hints for database columns
    protected $casts = [
        'rented_out' => 'boolean'
    ];
}
