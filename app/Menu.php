<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'id', 'name', 'description', 'price', 'active', 'location_id', 'category_id'
    ];
    
    public function Location(){
        
        return $this->belongsTo('App\Location');
    }

    public function Category(){
        
        return $this->belongsTo('App\Category');
    }
}