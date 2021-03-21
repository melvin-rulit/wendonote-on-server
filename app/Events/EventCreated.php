<?php

namespace App\Events;

use App\Job_category;
use App\Mail\EventCreatedMail;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Mail;


use App\Event as Event_model;

use App\Default_Jobs;
use App\Default_Job_Categories;
use App\Job;
use App\Calendar_Event;

class EventCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        if(env('APP_ENV') != 'local')
            Mail::to($event->user->email)->send(new EventCreatedMail($event));


        $default_categories = Default_Job_Categories::all();

        foreach ($default_categories as $default_category)
        {
            $new_category = Job_category::create(
                [
                    'event_id' => $event->id,
                    'name' => $default_category->name,
                    'color' => $default_category->color
                ]);

            foreach ($default_category->Jobs()->get() as $default_job)
            {
                $new_job = Job::create([
                            'category_id' => $new_category->id,
                            'name' => $default_job->name,
                            'note' => '...',
                            'seqid' => 0,
                            'default_job_id' => $default_job->id
                        ]);

                Calendar_Event::create([
                    'job_id' => $new_job->id,
                    'creation' => Carbon::now(),
                    'deadline' => Calendar_Event::countDeadLine($event, $default_job)
                ]);
            }
        }



    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
