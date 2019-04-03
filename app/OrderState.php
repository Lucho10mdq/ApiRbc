<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderState extends Model
{
    protected $table = 'orders_states';

    protected $fillable = [
        'description'
    ];

    public function orden(){
        return $this->hasMany('App\Order');
    }
}
