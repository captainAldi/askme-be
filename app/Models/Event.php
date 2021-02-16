<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    public function questions(){
        return $this->hasMany('App\Models\Question');
    }
}
