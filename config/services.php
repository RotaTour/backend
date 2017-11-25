<?php

/*
 * http://devartisans.com/articles/complete-laravel5-socialite-tuorial
 * https://www.cloudways.com/blog/social-login-in-laravel-using-socialite/
 */

$GITHUB_CLIENT_ID = '322c2a748a35f040f124';
$GITHUB_CLIENT_SECRET = '4b888d7176b4749c2cbb67296176ce2ba5392bac';
$GITHUB_REDIRECT = 'https://rotatourapi.herokuapp.com/social/callback/github';

$FACEBOOK_CLIENT_ID = '';
$FACEBOOK_CLIENT_SECRET = '';
$FACEBOOK_REDIRECT = '';

$GOOGLE_CLIENT_ID = '';
$GOOGLE_CLIENT_SECRET = '';
$GOOGLE_REDIRECT = '';

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID', $GITHUB_CLIENT_ID),         // Your GitHub Client ID
        'client_secret' => env('GITHUB_CLIENT_SECRET', $GITHUB_CLIENT_SECRET), // Your GitHub Client Secret
        'redirect' => $GITHUB_REDIRECT,
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', $FACEBOOK_CLIENT_ID),         // Your GitHub Client ID
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', $FACEBOOK_CLIENT_SECRET), // Your GitHub Client Secret
        'redirect' => 'http://your-callback-url',
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', $GOOGLE_CLIENT_ID),         // Your GitHub Client ID
        'client_secret' => env('GOOGLE_CLIENT_SECRET', $GOOGLE_CLIENT_SECRET), // Your GitHub Client Secret
        'redirect' => 'http://your-callback-url',
    ],

];
