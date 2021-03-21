<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog_group extends Model
{
    protected $fillable = ['name', 'description', 'photo'];
}