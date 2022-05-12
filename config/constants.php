<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Defined Variables
    |--------------------------------------------------------------------------
    |
    | This is a set of variables that are made specific to this application
    | that are better placed here rather than in .env file.
    | Use config('your_key') to get the values.
    |
    */

    'pdf_path' => env('PDF_PATH','pdf/booking'),
    'subject_booking' => env('SUBJECT_BOOKING','Email confirmation iWaNaTrip.com'),
    'title_booking' => env('TITLE_BOOKING','Email confirmation iWaNaTrip.com'),
    'email_iwannatrip' => env('EMAIL_IWANNATRIP','info@iwannatrip.com'),

];