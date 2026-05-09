<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Used for webhooks verification
    'webhook' => [
        // Optional but recommended (if you set it on Midtrans dashboard)
        'secret' => env('MIDTRANS_WEBHOOK_SECRET'),
    ],

    // Base callback URLs
    'callbacks' => [
        'finish' => env('MIDTRANS_CALLBACK_FINISH_URL'),
        'notification' => env('MIDTRANS_CALLBACK_NOTIFICATION_URL'),
    ],
];

