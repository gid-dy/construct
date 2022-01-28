<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicetype extends Model
{
    protected $fillable = [
        'ServiceType', 'ServiceSize','SKU', 'ServicePrice', 'Service_id',
    ];
}
