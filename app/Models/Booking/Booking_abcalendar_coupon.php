<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking_abcalendar_coupon extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_abcalendar_coupon';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo', 'fecha_expiracion', 'cantidad', 'estado', 'id_res_origen', 'id_res_cons', 'min_pass'];

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
    protected $casts = ['estado' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha_expiracion'];

}