<?php

namespace App\Core;

class Router
{
    public $middlewareAliases;
    protected $routes = [];
    public $middlewares = [];
    protected $notFoundCallback;

    // No construtor do Router
    public function __construct()
    {
        $this->middlewareAliases = require __DIR__ . '/../config/middlewares.php';
    }

    // Adiciona middleware global
    public function addMiddleware($middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    // Configura callback para 404
    public function setNotFound($callback): void
    {
        $this->notFoundCallback = $callback;
    }

    // Método add modificado para aceitar middlewares
    public function add(string $method, string $path, $callback, array $middlewares = []): void
    {
        $this->routes[strtoupper($method)][$path] = [
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    public function resolveMiddleware($middleware, $type = 'global')
    {
        if (is_string($middleware) && isset($this->middlewareAliases[$type][$middleware])) {
            return new $this->middlewareAliases[$type][$middleware];
        }
        return $middleware;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = rtrim($path, '/');
        $path = $path == '' ? '/' : $path;

        // Executa middlewares globais
        foreach ($this->middlewares as $middleware) {
            if ((new $middleware)->handle() === false) {
                return; // Interrompe se o middleware falhar
            }
        }

        // Verifica rota exata
        if (isset($this->routes[$method][$path])) {
            $this->executeRoute($this->routes[$method][$path]);
            return;
        }

        // Verifica rotas dinâmicas
        foreach ($this->routes[$method] as $route => $config) {
            $pattern = '#^' . preg_replace('/\{(\w+)\}/', '(?<$1>[^/]+)', $route) . '$#';
            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->executeRoute($config, $params);
                return;
            }
        }

        // 404
        http_response_code(404);
        ($this->notFoundCallback) ? $this->notFoundCallback->__invoke() : die('404');
    }

    protected function executeRoute(array $routeConfig, array $params = []): void
    {
        // Executa middlewares da rota
        foreach ($routeConfig['middlewares'] as $middleware) {
            if ($this->resolveMiddleware($middleware, 'aliases')->handle() === false) {
                return; // Interrompe se algum middleware falhar
            }
        }

        // Executa o callback principal
        if (is_callable($routeConfig['callback'])) {
            call_user_func_array($routeConfig['callback'], [$params]);
        } elseif (is_array($routeConfig['callback'])) {
            [$class, $method] = $routeConfig['callback'];
            (new $class)->$method($params);
        }
    }
}
