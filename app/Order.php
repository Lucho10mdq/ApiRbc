<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Event;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'table_id','order_state_id',
    'date_hour'];

    public static function boot() {
        parent::boot() ;

        static::created( function( $order ) {
            Event::fire('OrderEvent.created', $order ) ;
        } );

        static::updated( function( $order ) {
            Event::fire('OrderEvent.updated', $order ) ;
        } );

    }

    public function Table(){
        return $this->belongsTo('App\Table');
    }

    public function OrderState(){
        return $this->belongsTo('App\OrderState');
    }

    public function Plates(){
        return $this->hasMany('App\Plate');
    }

    public function Waiter(){
        return $this->belongsToMany('App\Waiter');
    }
}
