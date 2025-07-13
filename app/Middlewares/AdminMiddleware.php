<?php

namespace App\Middlewares;

class AdminMiddleware
{
    public function handle(): bool
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            return false;
        }
        return true;
    }
}
