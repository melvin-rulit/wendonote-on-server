<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitee extends Model
{
    protected $fillable = ['inivation_id', 'name'];

    // public function post(){
    //     return $this->belongsTo('App\Inivation');
    // } 
}
