<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class People extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'doc', 'address', 'phone', 'email'
    ];

    public function waiter()
    {
        return $this->hasOne('App\Waiter');
    }

    public function Customer(){
        
        return $this->hasOne('App\Customer');
    }
}
