<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'client_id',
        'car_id',
        'log_number',
        'event',
        'event_time',
        'document_id'
    ];
}
