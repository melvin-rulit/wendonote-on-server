<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inivation extends Model
{
    protected $fillable = ['user_id', 'name', 'text', 'background', 'send', 'status'];

    public function invitee(){
        return $this->hasMany('App\Invitee');
    } 
}
