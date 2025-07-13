<?php

namespace App\Middlewares;

class MaintenanceMiddleware
{
    public function handle()
    {
        error_log("Middleware global: " . $_SERVER['REQUEST_URI']);
        return true;
    }
}
