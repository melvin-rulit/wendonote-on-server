<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Default_Jobs extends Model
{
    protected $fillable = ['category_id', 'name', 'link_name', 'link_href', 'priority'];
    protected $table = 'jobs_default';
    public $timestamps = false;
}
