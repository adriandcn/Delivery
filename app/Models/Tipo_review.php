<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_review extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipo_reviews';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo_review', 'tipo_estado', 'descripcion', 'catalogo_servicio', 'tipo_review_eng', 'peso_review'];

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
    protected $dates = ['createat', 'updateat', 'createat', 'updateat', 'modified', 'uploaded', 'date_from', 'date_to', 'issue_date', 'due_date', 'created', 'modified', 'processed_on', 's_date', 'created', 'dt', 'start_date', 'end_date', 'date_from', 'date_to', 'created', 'date_from', 'date_to', 'modified', 'created', 'processed_on', 'created', 'last_login', 'fecha_creacion', 'fecha_fin', 'fecha_creacion_servicio', 'fecha_fin_servicio', 'fecha_inicio', 'fecha_fin', 'fecha_desde', 'fecha_hasta', 'fecha', 'fecha_desde', 'fecha_hasta', 'fecha', 'fecha_pago', 'fecha_desde', 'fecha_hasta', 'fecha_revision'];

}