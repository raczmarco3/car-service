<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    protected $table = 'cars';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'client_id',
        'car_id',
        'type',
        'registered',
        'ownbrand',
        'accident'
    ];
}
