<?php
/**
 * Created by PhpStorm.
 * User: ic
 * Date: 01.05.2017
 * Time: 11:21
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Default_Job_Categories extends Model
{
    /* Defining contsts for the model*/

    protected $fillable = ['name', 'color'];
    protected $table = 'job_categories_default';
    public $timestamps = false;


    //Relationship

    /* THAT'S DEFAULT JOBS RELATS */
    public function Jobs()
    {
        return $this->hasMany('App\Default_Jobs', 'category_id', 'id');
    }
}