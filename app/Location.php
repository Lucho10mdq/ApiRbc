<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'id', 'description'
    ];
    
    public function menus()
    {
        return $this->hasMany('App\Menu');
    }
}