<?php

return [
    'vietqr' => [
        'bank_bin' => env('VIETQR_BANK_BIN'),
        'account' => env('VIETQR_ACCOUNT'),
        'account_name' => env('VIETQR_ACCOUNT_NAME'),
    ],

    'ghn' => [
    'token' => env('GHN_TOKEN'),
    'shop_id' => env('GHN_SHOP_ID'),
    'api_url' => env(
        'GHN_API_URL',
        'https://online-gateway.ghn.vn'
    ),
    'service_type_id' => 2,
    'default_weight' => 500,
    ],

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
