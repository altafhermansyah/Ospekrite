<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Notification Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default notification "driver" that will be used
    | to send alerts to admins. Supported: "telegram", "dummy"
    |
    */

    'default' => env('NOTIFICATION_DRIVER', 'telegram'),

    /*
    |--------------------------------------------------------------------------
    | Notification Drivers Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the notification drivers. Placeholders are
    | provided for future implementations.
    |
    */

    'drivers' => [
        'telegram' => [
            // Uses credentials from config/services.php
        ],

        'dummy' => [
            // No configuration needed. Writes to Laravel Log.
        ],

        'fonnte' => [
            'token' => env('FONNTE_TOKEN'),
        ],

        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],

        'whatsapp_business' => [
            'token' => env('WA_BUSINESS_TOKEN'),
            'phone_number_id' => env('WA_PHONE_NUMBER_ID'),
        ],

        'email' => [
            // Uses default Mail configuration
        ],
    ],

];
