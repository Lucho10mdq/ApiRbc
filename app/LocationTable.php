<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationTable extends Model
{
    protected $table = 'locations_tables';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'description'
    ];

    public function waiters()
    {
        return $this->belongsToMany('App\Waiter')->withDefault();
    }

    public function tables()
    {
        return $this->hasMany( 'App\Table' ) ;
    }


}