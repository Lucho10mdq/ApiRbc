<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plate extends Model
{
    protected $fillable = [
        'price','menu_id','order_id','plate_state_id'
    ];

    public function PlateState(){
        return $this->belongsTo('App\PlateState');
    }

    public function order(){
        return $this->belongsTo('App\Order');
    }

    public function Menu(){
        return $this->belongsTo('App\Menu');
    }
}
