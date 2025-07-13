<?php

namespace App\Middlewares;

class GuestMiddleware
{
    public function handle(): bool
    {
        if (isset($_SESSION['user'])) {
            header('Location: /');
            return false;
        }
        return true;
    }
}
