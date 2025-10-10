<?php


return [
    // PayPal credentials and endpoints
    'client_id' => env('PAYPAL_CLIENT_ID', ''),
    'secret' => env('PAYPAL_SECRET', ''),
    // legacy and new base URLs
    'base_url' => env('PAYPAL_BASE_URL', ''),
    'base_new_url' => env('PAYPAL_BASE_NEW_URL', ''),
    'mode' => env('PAYPAL_MODE', 'sandbox'),
    'merchant_id_live' => env('PAYPAL_MERCHANTID_LIVE', ''),
    'merchant_id_stag' => env('PAYPAL_MERCHANTID_STAG', ''),
    'settings' => [
        'log.LogEnabled' => true,
        'log.FileName' => storage_path('logs/paypal.log'),
        'log.LogLevel' => 'ERROR',
    ],
];
//         'secret'      => env('PAYPAL_LIVE_API_SECRET', ''),
