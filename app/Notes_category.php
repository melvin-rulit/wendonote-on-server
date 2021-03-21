<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notes_category extends Model
{
        /* Defining constants */
    protected $fillable = ['event_id', 'name', 'color'];
    protected $table = 'notes_categories';
    public $timestamps = true;

    /**
     * Eloquent relationship between models: Jobs, $this
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Notes()
    {
        return $this->hasMany('App\Note', 'category_id', 'id');
    }

    /**
     * Eloquent relationship between models: Event, $this
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Event()
    {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }
}
