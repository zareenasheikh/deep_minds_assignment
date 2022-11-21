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

    'facebook' => [
    'client_id' => '868073487790181',
    'client_secret' => 'bd1184259769af607e8f56f090c8f214',
    'redirect' => 'http://localhost/deep_minds_demo/oauth/facebook/callback',
],



    'google' => [
        'client_id' => '1021436299576-vr1lh866qa8pgl7ifedgg9skl8gbhqkh.apps.googleusercontent.com',
        'client_secret' => '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',
            'redirect' => 'http://localhost/deep_minds_demo/oauth/google/callback',

    ],



    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
