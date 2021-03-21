<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu_group extends Model
{

	protected $fillable = [
        'name', 'user_id',
    ];

    public function menu(){
        return $this->hasMany('App\Menu');
    } 
}
