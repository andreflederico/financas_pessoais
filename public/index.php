<?php
// Define o caminho absoluto para o diretório raiz do projeto.
// Isso garante que os includes e requires funcionem corretamente,
// independentemente de onde o script é executado.
define('ROOT_PATH', dirname(__DIR__)); // Define ROOT_PATH como o diretório pai de 'public' (e.g., /financas_pessoais)

// Carrega o autoloader do Composer.
// O Composer gerencia as dependências e o autoloading das classes do projeto (e.g., vlucas/phpdotenv).
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
} else {
    // Se o autoload.php não for encontrado, significa que 'composer install' não foi executado.
    die('O arquivo autoload.php do Composer não foi encontrado. Por favor, execute "composer install" na raiz do projeto.');
}

// Carrega as variáveis de ambiente do arquivo .env.
// Isso permite que configurações sensíveis (como credenciais de banco de dados)
// sejam mantidas fora do controle de versão e sejam específicas do ambiente.
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Inicia a sessão PHP.
// A sessão é fundamental para gerenciar o estado do usuário, como autenticação.
session_start();

require_once ROOT_PATH . '/app/Utils/helpers.php'; // <--- ESTA LINHA É CRÍTICA!

$router = require __DIR__ . '/../app/routes.php';
$router->dispatch();
