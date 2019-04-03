<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Waiter extends Model
{
    use SoftDeletes;
    protected $filliable =[
        'code', 'people_id'
    ];

    public function people()
    {
        return $this->belongsTo('App\People');
    }

    public function locationsTables()
    {
        return $this->belongsToMany('App\LocationTable');
    }

    public function order()
    {
        return $this->belongsToMany('App\Order')->withDefault();
    }
}
