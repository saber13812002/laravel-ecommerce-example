<?php

return [
    'php_group' => [
        'token' => env('EITAA_TOKEN_GROUP_PHP'),
        'chat_id' => env('EITAA_CHAT_ID_GROUP_PHP'),
    ],
    'log_group' => [
        'token' => env('EITAA_TOKEN_GROUP_LOG'),
        'chat_id' => env('EITAA_CHAT_ID_GROUP_LOG'),
    ],
    'virgoolia_group' => [
        'token' => env('EITAA_TOKEN_GROUP_VIRGOOL'),
        'chat_id' => env('EITAA_CHAT_ID_GROUP_VIRGOOL'),
    ],
    'virgoolia_channel' => [
        'token' => env('EITAA_TOKEN_CHANNEL_VIRGOOL'),
        'chat_id' => env('EITAA_CHAT_ID_CHANNEL_VIRGOOL'),
    ]
];
