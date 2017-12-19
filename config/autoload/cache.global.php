<?php

return [
    'dependencies' => [
        'factories' => [
            App\Middleware\CacheMiddleware::class => App\Middleware\CacheFactory::class
        ]
    ]
];