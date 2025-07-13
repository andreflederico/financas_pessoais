<?php

use App\Controllers\TransactionController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Core\Router;
use App\Middlewares\MaintenanceMiddleware;

$router = new Router();

// Middleware global (executado em todas as rotas)
$router->addMiddleware(MaintenanceMiddleware::class);

// Rotas protegidas
$router->add('GET', '/', [DashboardController::class, 'index'], ['auth']);
$router->add('GET', '/chart-data', [DashboardController::class, 'getChartData']);
$router->add('GET', '/transacoes', [TransactionController::class, 'index'], ['auth']);

// Rotas com CSRF
$router->add('POST', '/transacoes', [TransactionController::class, 'store'], ['auth', 'csrf']);

// Rota pública
$router->add('GET', '/login', [AuthController::class, 'showLogin'], ['guest']);
$router->add('POST', '/login', [AuthController::class, 'login'], ['guest']);
// Redefinição de senha
$router->add('GET', '/forgot-password', [AuthController::class, 'showForgotPassword'], ['guest']);
$router->add('POST', '/forgot-password', [AuthController::class, 'sendResetLink'], ['guest']);
$router->add('GET', '/reset-password', [AuthController::class, 'showResetPassword'], ['guest']);
$router->add('POST', '/reset-password', [AuthController::class, 'updatePassword'], ['guest']);
$router->add('GET', '/register', [AuthController::class, 'showRegister'], ['guest']);
$router->add('POST', '/register', [AuthController::class, 'register'], ['guest']);
$router->add('POST', '/logout', [AuthController::class, 'logout'], ['auth']);

// 404 Personalizado
$router->setNotFound(function () {
    header("HTTP/1.0 404 Not Found");
    require __DIR__ . '/Views/errors/404.php';
    exit;
});

return $router;
