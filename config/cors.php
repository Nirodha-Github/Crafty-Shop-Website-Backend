<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*','login','register','admin/*','sanctum/csrf-cookie'],

    'allowed_methods' =>  ['GET', 'PUT', 'POST', 'DELETE', 'OPTIONS', 'PATCH','HEAD'],

    'allowed_origin' => ['http://localhost:3000'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [  
        
        'Content-Type', 
        'Authorization', 
        'Accept',
        'User-Agent',
        'Cache-Control',
        //'Accept-Language',
       // 'Content-Language',
        'Origin',
        'X-Requested-With',
        'X-XSRF-TOKEN',
        'X-Content-Type-Options'
        //'X-CSRF-TOKEN',

        
        ],

    'exposed_headers' => [
        'Content-Length',
        'Content-Range'       
    ],

    'max_age' => false,

    'supports_credentials' => true,

    


];
