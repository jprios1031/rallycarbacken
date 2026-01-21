<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://rallycarfronted-production.up.railway.app'],
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];

