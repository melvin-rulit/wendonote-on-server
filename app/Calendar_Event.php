<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Event;
use App\Default_Jobs;

class Calendar_Event extends Model
{
    protected $table = 'calendar_events';
    protected $fillable = ['job_id', 'creation', 'deadline'];
    public $timestamps = false;

    protected $dates = ['creation', 'deadline'];

    /* Eloquent */

    public function Job()
    {
        return $this->belongsTo('App\Job', 'job_id', 'id');
    }

    /* Static method for deadline */

    public static function countDeadLine(Event $event, $default_job, $priority = null)
    {
        if($priority == null)
            $priority = $default_job->priority;
        else
            $priority = 1;

        return Carbon::now()->addDays(intval((($event->date->diffInDays(Carbon::now())/20)*(20-$priority))));
    }

}
