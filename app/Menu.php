<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'menu_group_id', 'name', 'kolvo', 'weight', 'price' , 'summ',
    ];
}
