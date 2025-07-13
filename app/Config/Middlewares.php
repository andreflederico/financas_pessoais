<?php
return [
    'global' => [
        \App\Middlewares\MaintenanceMiddleware::class
    ],
    'aliases' => [
        'guest' => \App\Middlewares\GuestMiddleware::class,
        'auth' => \App\Middlewares\AuthMiddleware::class,
        'csrf' => \App\Middlewares\CsrfMiddleware::class,
        'admin' => \App\Middlewares\AdminMiddleware::class
    ]
];
