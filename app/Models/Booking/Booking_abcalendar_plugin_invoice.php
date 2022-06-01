<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking_abcalendar_plugin_invoice extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_abcalendar_plugin_invoice';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'order_id', 'foreign_id', 'locale_id', 'issue_date', 'due_date', 'created', 'modified', 'status', 'payment_method', 'cc_type', 'cc_num', 'cc_exp_month', 'cc_exp_year', 'cc_code', 'txn_id', 'processed_on', 'subtotal', 'discount', 'tax', 'shipping', 'total', 'paid_deposit', 'amount_due', 'currency', 'notes', 'y_logo', 'y_company', 'y_name', 'y_street_address', 'y_country', 'y_city', 'y_state', 'y_zip', 'y_phone', 'y_fax', 'y_email', 'y_url', 'b_billing_address', 'b_company', 'b_name', 'b_address', 'b_street_address', 'b_country', 'b_city', 'b_state', 'b_zip', 'b_phone', 'b_fax', 'b_email', 'b_url', 's_shipping_address', 's_company', 's_name', 's_address', 's_street_address', 's_country', 's_city', 's_state', 's_zip', 's_phone', 's_fax', 's_email', 's_url', 's_date', 's_terms', 's_is_shipped'];

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