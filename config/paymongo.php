<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayMongo API Keys
    |--------------------------------------------------------------------------
    |
    | Your PayMongo API keys for authentication.
    | Get your keys from https://dashboard.paymongo.com/developers
    |
    */
    'public_key' => env('PAYMONGO_PUBLIC_KEY', ''),
    'secret_key' => env('PAYMONGO_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | PayMongo API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for PayMongo API requests.
    |
    */
    'base_url' => env('PAYMONGO_BASE_URL', 'https://api.paymongo.com/v1'),

    /*
    |--------------------------------------------------------------------------
    | Certificate Payment Amount
    |--------------------------------------------------------------------------
    |
    | The amount to charge for each certificate request (in PHP).
    |
    */
    'certificate_amount' => env('CERTIFICATE_AMOUNT', 50.00),
];
