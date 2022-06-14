<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery_book extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'delivery_book';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_reserva', 'enviado'];

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
    protected $casts = ['enviado' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

}