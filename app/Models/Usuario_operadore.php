<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario_operadore extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuario_operadores';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario_op', 'nombre_empresa_operador', 'password_operador', 'reset_password_operador', 'nombre_contacto_operador_1', 'telf_contacto_operador_1', 'telf_contacto_operador_2', 'nombre_contacto_operador_2', 'email_contacto_operador', 'estado_contacto_operador', 'ip_registro_operador', 'id_tipo_operador', 'id_usuario', 'direccion_empresa_operador'];

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
    protected $casts = ['reset_password_operador' => 'boolean', 'estado_contacto_operador' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['createat', 'updateat', 'createat', 'updateat', 'modified', 'uploaded', 'date_from', 'date_to', 'issue_date', 'due_date', 'created', 'modified', 'processed_on', 's_date', 'created', 'dt', 'start_date', 'end_date', 'date_from', 'date_to', 'created', 'date_from', 'date_to', 'modified', 'created', 'processed_on', 'created', 'last_login', 'fecha_creacion', 'fecha_fin', 'fecha_creacion_servicio', 'fecha_fin_servicio', 'fecha_inicio', 'fecha_fin', 'fecha_desde', 'fecha_hasta', 'fecha', 'fecha_desde', 'fecha_hasta', 'fecha', 'fecha_pago', 'fecha_desde', 'fecha_hasta', 'fecha_revision'];

}