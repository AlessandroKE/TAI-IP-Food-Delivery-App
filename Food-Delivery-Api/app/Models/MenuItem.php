<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    //
    protected $fillable=['restaurant_id','name','description','price', 'is_available'];

    public function restaurant(){
        return $this->belongsToMany(Restaurant::class);
    }
}
