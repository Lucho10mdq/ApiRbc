<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlateState extends Model
{
    protected $table = 'plate_states';

    protected $fillable = [
        'description'
    ];

    public function Plates(){
        return $this->hasMany('App\Plate');
    }
}
