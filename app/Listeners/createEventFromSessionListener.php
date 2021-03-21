<?php

namespace App\Listeners;

use App\Events\createEventFromSessionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;

use App\Event;
use App\City;
use App\Event_type;

class createEventFromSessionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  createEventFromSessionEvent  $event
     * @return void
     */
    public function handle(createEventFromSessionEvent $event)
    {
        $user_id = $event->user_id;

        if(Session::has('event'))
        {
            $data = Session::pull('event');

            if(Event::where('user_id', $user_id)->count() == 0)
            {
                Event::create([
                    'user_id' => $user_id,
                    'city_id' => City::where('name', $data['city'])->first()->id,
                    'event_type_id' => Event_type::where('name', $data['event_type'])->first()->id,
                    'name' => $data['name'],
                    'date' => $data['date']
                ]);
            }
        }

    }
}
