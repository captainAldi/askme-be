<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function event(){
        return $this->belongsTo('App\Models\Event', 'event_id', 'id');
    }
}
