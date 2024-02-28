<?php

// Setting for Midtrans API 
return [
    'mercant_id' => env('MIDTRANS_MERCHAT_ID'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),

    // production for sandbox
    'is_production' => false,
    'is_sanitized' => false,
    'is_3ds' => false,
];
