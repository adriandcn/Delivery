<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogo_servicio_establecimiento extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'catalogo_servicio_establecimiento';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['estado_servicio_est', 'id_catalogo_servicio', 'nombre_servicio_est', 'url_image', 'nombre_servicio_est_eng', 'catalogo_especifico'];

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
    protected $casts = ['estado_servicio_est' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['createat', 'updateat', 'createat', 'updateat', 'modified', 'uploaded', 'date_from', 'date_to', 'issue_date', 'due_date', 'created', 'modified', 'processed_on', 's_date', 'created', 'dt', 'start_date', 'end_date', 'date_from', 'date_to', 'created', 'date_from', 'date_to', 'modified', 'created', 'processed_on', 'created', 'last_login', 'fecha_creacion', 'fecha_fin'];

}