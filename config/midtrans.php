<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', env('MIDTRANS_MERCHAT_ID')),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'signature_key' => env('MIDTRANS_SIGNATURE_KEY'),

    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => false,
    'is_3ds' => false,

    'snap_js_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
];
