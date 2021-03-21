<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = ['job_id', 'qty', 'price', 'difference'];
    protected $table = 'budgets';
    public $timestamps = false;

    /* Eloquent relations*/

    public function Job()
    {
        return $this->belongsTo('App\Job', 'job_id', 'id');
    }
}
