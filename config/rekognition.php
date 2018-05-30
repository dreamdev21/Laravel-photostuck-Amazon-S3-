<?php

return [
    'credentials' => [
        'key'    => env('S3_KEY'),
        'secret' => env('S3_SECRET'),
    ],
    'region' => env('S3_REGION'),
    'version' => 'latest'
];
