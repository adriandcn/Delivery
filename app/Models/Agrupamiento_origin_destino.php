<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agrupamiento_origin_destino extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agrupamiento_origin_destino';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_agrupamiento_origin_destino', 'id_agrupamiento', 'id_canton', 'id_provincia', 'id_region', 'status', 'id_canton_destino', 'id_provincia_destino'];

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
    protected $dates = [];

}