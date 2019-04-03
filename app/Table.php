<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'number', 'capacity', 'location_table_id'
    ] ;

    public function locationTable()
    {
        return $this->belongsTo('App\LocationTable');
    }

    public function order(){
        return $this->hasMany('App\Order');
    }
}
