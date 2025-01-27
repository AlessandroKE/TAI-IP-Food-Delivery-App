<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['name', 'cuisine', 'location', 'description', 'rating', 'image_url'];

    public function MenuItems(){
        return $this->hasMany(MenuItem::class);
    }

}
