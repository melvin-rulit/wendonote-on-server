<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Guest;

class Contact extends Model
{
        protected $fillable = [
        'event_id',
        'name',
    ];


    public static function getContact($event_id)
    {
        $contact = Contact::where(['event_id' => $event_id]);
        return $contact->get();
    }

    public static function getGuestContact($event_id)
    {
        $guests = Guest::where(['event_id' => $event_id]);
        return $guests->get();
    }
}
