<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking_abcalendar_field extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_abcalendar_fields';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'type', 'label', 'source', 'modified'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['createat', 'updateat', 'createat', 'updateat', 'modified'];

}