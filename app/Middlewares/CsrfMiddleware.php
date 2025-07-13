<?php

namespace App\Middlewares;

class CsrfMiddleware
{
    public function handle(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['_token'] !== $_SESSION['_token']) {
                http_response_code(419);
                die('Token CSRF inválido');
            }
        }
        return true;
    }
}
