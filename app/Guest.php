<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = 'guests';

    protected $fillable = [
        'event_id',
        'name',
        'gender',
        'status',
        'contacts_cell',
        'contacts_email',
        'contacts_instagram',
        'contacts_facebook',
        'contacts_vk',
        'contacts_ok',
        'contacts_viber',
        'contacts_telegram'
    ];

    public $timestamps = false;

    /* Extra stuff */

    public static function getGuests($event_id, $gender, $status)
    {
        $guests = self::where(['event_id' => $event_id, 'gender' => $gender, 'status' => $status]);
        return $status == 'married' ? $guests->first() : $guests->get();
    }


    public static function getGuestsNumber($event_id)
    {
        return self::where('event_id', $event_id)->count();
    }

    public static function getGuestsNumberByGender($event_id, $gender)
    {
        return self::where([
            'event_id' => $event_id,
            'gender' => $gender
        ])->count();
    }


}
