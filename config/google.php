<?php

//$googleKey = "AIzaSyAa42oli-edAepQHbkhPmgjx6Cdtw-DMe0"; // HTTPS
$googleKey = "AIzaSyDC78sDqyVnaYu9M7oVjtVpHRzsA7h2UaI"; // No restriction

return [
    'places' => [
        'key' => env('GOOGLE_PLACES_API_KEY', $googleKey)
    ],
];
