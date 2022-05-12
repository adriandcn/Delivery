<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking_abcalendar_reservation extends Model  {

    public $timestamps = false;
        
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_abcalendar_reservations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['calendar_id', 'uuid', 'date_from', 'date_to', 'price_based_on', 'c_name', 'c_lastname', 'c_cedula', 'c_email', 'c_phone', 'c_adults', 'c_children', 'c_notes', 'c_address', 'c_city', 'c_country', 'c_state', 'c_zip', 'modified', 'created', 'ip', 'amount', 'deposit', 'tax', 'security', 'payment_method', 'cc_type', 'cc_num', 'cc_exp_month', 'cc_exp_year', 'cc_code', 'txn_id', 'processed_on', 'status', 'locale_id', 'tipo_usuario', 'token_consulta', 'estado_review'];

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
    protected $casts = ['estado_review' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['createat', 'updateat', 'createat', 'updateat', 'modified', 'uploaded', 'date_from', 'date_to', 'issue_date', 'due_date', 'created', 'modified', 'processed_on', 's_date', 'created', 'dt', 'start_date', 'end_date', 'date_from', 'date_to', 'created', 'date_from', 'date_to', 'modified', 'created', 'processed_on'];

}