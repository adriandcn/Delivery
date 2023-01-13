<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking_abcalendar_plugin_invoice_config extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_abcalendar_plugin_invoice_config';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['y_logo', 'y_country', 'y_zip', 'y_phone', 'y_fax', 'y_email', 'y_url', 'p_accept_payments', 'p_accept_paypal', 'p_accept_authorize', 'p_accept_creditcard', 'p_accept_cash', 'p_accept_bank', 'p_authorize_tz', 'p_authorize_key', 'p_authorize_mid', 'p_authorize_hash', 'si_include', 'si_shipping_address', 'si_company', 'si_name', 'si_address', 'si_street_address', 'si_city', 'si_state', 'si_zip', 'si_phone', 'si_fax', 'si_email', 'si_url', 'si_date', 'si_terms', 'si_is_shipped', 'si_shipping', 'o_booking_url', 'o_qty_is_int', 'o_use_qty_unit_price'];

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
    protected $dates = ['createat', 'updateat', 'createat', 'updateat', 'modified', 'uploaded', 'date_from', 'date_to', 'issue_date', 'due_date', 'created', 'modified', 'processed_on', 's_date'];

}