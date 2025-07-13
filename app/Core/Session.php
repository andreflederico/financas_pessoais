<?php

namespace App\Core;

/**
 * Classe Session
 * Gerencia as operações de sessão PHP, incluindo dados de usuário e mensagens flash.
 * Fornece uma interface segura e fácil de usar para interagir com $_SESSION.
 */
class Session
{
    /**
     * Construtor da classe Session.
     * Garante que a sessão PHP já foi iniciada.
     */
    public function __construct()
    {
        // session_start() já é chamado em public/index.php.
        // Esta verificação é mais uma garantia, embora não estritamente necessária aqui.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Define um valor na sessão.
     *
     * @param string $key A chave para armazenar o valor.
     * @param mixed $value O valor a ser armazenado.
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Obtém um valor da sessão.
     *
     * @param string $key A chave do valor a ser recuperado.
     * @param mixed $default O valor padrão a ser retornado se a chave não existir.
     * @return mixed O valor da sessão ou o valor padrão.
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Verifica se uma chave existe na sessão.
     *
     * @param string $key A chave a ser verificada.
     * @return bool True se a chave existir, false caso contrário.
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove uma chave da sessão.
     *
     * @param string $key A chave a ser removida.
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destrói toda a sessão.
     */
    public function destroy(): void
    {
        session_unset();   // Remove todas as variáveis de sessão
        session_destroy(); // Destrói os dados da sessão no servidor
        setcookie(session_name(), '', time() - 3600, '/'); // Remove o cookie de sessão do navegador
    }

    /**
     * Define uma mensagem flash (que será exibida uma vez e depois removida).
     * Útil para mensagens de sucesso, erro ou alerta após um redirecionamento.
     *
     * @param string $type O tipo da mensagem (ex: 'success', 'error', 'warning').
     * @param string|array $message A mensagem ou um array de mensagens.
     */
    public function setFlash(string $type, $message): void
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Obtém todas as mensagens flash e as remove da sessão.
     *
     * @return array Um array associativo de mensagens flash por tipo.
     */
    public function getFlashMessages(): array
    {
        $flashMessages = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']); // Remove as mensagens flash após serem lidas
        return $flashMessages;
    }

    /**
     * Verifica se há mensagens flash de um tipo específico.
     *
     * @param string $type O tipo da mensagem flash a ser verificada.
     * @return bool True se existirem mensagens flash do tipo especificado, false caso contrário.
     */
    public function hasFlash(string $type): bool
    {
        return isset($_SESSION['flash'][$type]);
    }

    /**
     * Obtém mensagens flash de um tipo específico e as remove da sessão.
     *
     * @param string $type O tipo da mensagem flash a ser obtida.
     * @param mixed $default O valor padrão a ser retornado se não houver mensagens.
     * @return mixed As mensagens flash ou o valor padrão.
     */
    public function getFlash(string $type, $default = null)
    {
        $message = $_SESSION['flash'][$type] ?? $default;
        if (isset($_SESSION['flash'][$type])) {
            unset($_SESSION['flash'][$type]);
            // Se não houver mais mensagens flash de nenhum tipo, remove o array 'flash'
            if (empty($_SESSION['flash'])) {
                unset($_SESSION['flash']);
            }
        }
        return $message;
    }

    /**
     * Verifica se o usuário está logado.
     *
     * @return bool True se o user_id estiver na sessão, false caso contrário.
     */
    public function isLoggedIn(): bool
    {
        return $this->has('user_id');
    }

    /**
     * Obtém o ID do usuário logado.
     *
     * @return int|null O ID do usuário ou null se não estiver logado.
     */
    public function getUserId(): ?int
    {
        return $this->get('user_id');
    }
}
