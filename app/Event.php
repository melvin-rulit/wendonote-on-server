<?php
/**
 * Created by PhpStorm.
 * User: ic
 * Date: 26.04.2017
 * Time: 18:40
 */

namespace app;

use App\Events\EventCreated;
use Illuminate\Database\Eloquent\Model;

class Event extends Model{

    protected $fillable = ['user_id', 'city_id', 'event_type_id', 'name', 'date'];
    protected $dates = ['date'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function city()
    {
        return $this->hasOne('App\City', 'id', 'city_id');
    }

    public function event_type()
    {
        return $this->hasOne('App\Event_type', 'id', 'event_type_id');
    }

    public function job_categories()
    {
        return $this->hasMany('App\Job_category', 'event_id', 'id');
    }

    public function notes_categories()
    {
        return $this->hasMany('App\Notes_category', 'event_id', 'id');
    }

    /* Events */

    protected $events = [
        'created' => EventCreated::class
    ];
}