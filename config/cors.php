<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'], // ex: ['abc.com', 'api.abc.com','sgcpc.fedeguayas.com.ec']
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['*'], // 'Content-Type', 'X-Requested-With'
    'allowedMethods' => ['GET', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'], // ex: ['GET', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'] '*'
    'exposedHeaders' => [],
    'maxAge' => 0,

];
