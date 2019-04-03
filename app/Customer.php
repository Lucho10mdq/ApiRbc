<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable=[
        'id', 'contact', 'contact_phone'
    ];
    public $timestamps=false;

    public function People()
    {
        return $this->belongsTo('App\People');
    }
}
