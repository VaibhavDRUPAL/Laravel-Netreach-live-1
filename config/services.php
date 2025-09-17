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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'ip-stack' => [
        'url' => env('IPSTACK_URL', null),
        'key' => env('IPSTACK_ACCESS_KEY', null)
    ],

    'whatsapp' => [
        'url' => env('WP_BASE_URL'),
        'key' => env('WP_API_KEY'),
        'from' => env('WP_FROM'),
    ],

    'sms' => [
        'url' => env('SMS_BASE_URL'),
        'username' => env('SMS_USERNAME'),
        'password' => env('SMS_PASSWORD'),
        'from' => env('SMS_FROM'),
        'pe_id' => env('SMS_PE_ID'),
    ],
      'firebase_credentials' => env('FIREBASE_CREDENTIALS', 'fallback/path.json'),
];