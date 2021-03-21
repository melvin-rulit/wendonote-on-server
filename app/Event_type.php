<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_type extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
}
