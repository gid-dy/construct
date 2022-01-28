<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function servecategories(){
        return $this->hasMany('App\Category','id','id');
    }
}
