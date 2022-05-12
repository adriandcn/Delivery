<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalles_itinerario extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalles_itinerario';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_itinerario', 'lugar_punto', 'longitud_punto', 'latitud_punto', 'estado_punto', 'diahora_punto', 'descripcion_punto', 'incluye_punto', 'observaciones_punto', 'tags_punto'];

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
    protected $casts = ['estado_punto' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['createat', 'updateat', 'createat', 'updateat', 'modified', 'uploaded', 'date_from', 'date_to', 'issue_date', 'due_date', 'created', 'modified', 'processed_on', 's_date', 'created', 'dt', 'start_date', 'end_date', 'date_from', 'date_to', 'created', 'date_from', 'date_to', 'modified', 'created', 'processed_on', 'created', 'last_login', 'fecha_creacion', 'fecha_fin', 'fecha_creacion_servicio', 'fecha_fin_servicio', 'fecha_inicio', 'fecha_fin'];

}