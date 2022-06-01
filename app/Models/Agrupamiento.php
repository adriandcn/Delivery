<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agrupamiento extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agrupamiento';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario_servicio', 'nombre', 'descripcion', 'tags', 'estado', 'createat', 'updateat'];

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
    protected $dates = ['createat', 'updateat'];

}