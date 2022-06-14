<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario_servicio extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuario_servicios';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario_operador', 'id_catalogo_servicio', 'detalle_servicio', 'precio_desde', 'precio_hasta', 'precio_anterior', 'precio_actual', 'descuento_servico', 'direccion_servicio', 'longitud_servicio', 'latitud_servicio', 'estado_servicio', 'fecha_ingreso', 'fecha_fin', 'id_parroquia', 'correo_contacto', 'pagina_web', 'nombre_comercial', 'tags', 'calificacion_average', 'prioridad', 'num_visitas', 'descuento_clientes', 'estado_descuento_clientes', 'estado_descuento_no_clientes', 'nombre_servicio', 'tags_servicio', 'id_canton', 'estado_servicio_usuario', 'observaciones', 'telefono', 'id_provincia', 'como_llegar1', 'como_llegar2_2', 'como_llegar1_1', 'como_llegar2', 'id_padre', 'fecha_ultima_visita', 'horario', 'detalle_servicio_eng', 'fuente', 'id_catalogo_eventos'];

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
    protected $casts = ['estado_servicio' => 'boolean', 'estado_descuento_clientes' => 'boolean', 'estado_descuento_no_clientes' => 'boolean', 'estado_servicio_usuario' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['createat', 'updateat', 'createat', 'updateat', 'modified', 'uploaded', 'date_from', 'date_to', 'issue_date', 'due_date', 'created', 'modified', 'processed_on', 's_date', 'created', 'dt', 'start_date', 'end_date', 'date_from', 'date_to', 'created', 'date_from', 'date_to', 'modified', 'created', 'processed_on', 'created', 'last_login', 'fecha_creacion', 'fecha_fin', 'fecha_creacion_servicio', 'fecha_fin_servicio', 'fecha_inicio', 'fecha_fin', 'fecha_desde', 'fecha_hasta', 'fecha', 'fecha_desde', 'fecha_hasta', 'fecha', 'fecha_pago', 'fecha_desde', 'fecha_hasta', 'fecha_revision', 'fecha_ingreso', 'fecha_fin', 'fecha_ultima_visita'];

}