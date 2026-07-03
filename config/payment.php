<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Payment Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment "driver" that will be used on
    | requests. By default, it is set to "mock" for development purposes.
    | Future options: 'midtrans', 'xendit'.
    |
    */

    'default' => env('PAYMENT_DRIVER', 'mock'),

    /*
    |--------------------------------------------------------------------------
    | Mock Mode
    |--------------------------------------------------------------------------
    |
    | When set to true, the system will not make actual API calls to external
    | gateways, regardless of the driver chosen. Useful for testing.
    |
    */

    'mock_mode' => env('PAYMENT_MOCK_MODE', true),

    /*
    |--------------------------------------------------------------------------
    | Payment Timeout
    |--------------------------------------------------------------------------
    |
    | The default expiration time (in minutes) for a payment transaction
    | before it is considered expired by the gateway.
    |
    */

    'timeout_minutes' => env('PAYMENT_TIMEOUT', 1440), // Default 24 hours

    /*
    |--------------------------------------------------------------------------
    | Future Provider Settings
    |--------------------------------------------------------------------------
    |
    | Placeholders for future payment gateway configurations. Do not implement
    | SDK calls yet. This just reserves the structure for Stage 11+.
    |
    */

    'providers' => [
        'midtrans' => [
            'server_key' => env('MIDTRANS_SERVER_KEY'),
            'client_key' => env('MIDTRANS_CLIENT_KEY'),
            'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
            'snap_url' => env('MIDTRANS_SNAP_URL', 'https://app.sandbox.midtrans.com/snap/snap.js'),
        ],
        'xendit' => [
            'secret_key' => env('XENDIT_SECRET_KEY'),
            'public_key' => env('XENDIT_PUBLIC_KEY'),
        ],
    ],

];
