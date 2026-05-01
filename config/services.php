<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

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

    'blesta' => [
        'url' => env('BLESTA_URL'),
        'api_user' => env('BLESTA_API_USER'),
        'api_key' => env('BLESTA_API_KEY'),
        'department_id' => env('BLESTA_SUPPORT_DEPARTMENT_ID'),
        'client_group_id' => env('BLESTA_CLIENT_GROUP_ID'),
        'shared_login_key' => env('BLESTA_SHARED_LOGIN_KEY'),
    ],

    'notdone_admin' => [
        'slug_availability_url' => env('NOTDONE_ADMIN_SLUG_AVAILABILITY_URL', 'https://admin.notdone.cloud/api/admin/workspaces/slug-availability'),
        'token' => env('NOTDONE_ADMIN_API_TOKEN'),
    ],

    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
        'siteverify_url' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
    ],

];
