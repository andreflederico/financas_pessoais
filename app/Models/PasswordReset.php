<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class PasswordReset
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    /**
     * Cria um token de redefinição de senha
     */
    public function create(int $userId): string
    {
        // Remove tokens existentes para o usuário
        $this->pdo->prepare(
            "DELETE FROM password_resets WHERE user_id = ?"
        )->execute([$userId]);

        // Gera novo token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $this->pdo->prepare(
            "INSERT INTO password_resets (user_id, token, expires_at)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([$userId, $token, $expiresAt]);

        return $token;
    }

    /**
     * Valida um token de redefinição
     */
    public function validate(string $token): ?int
    {
        $stmt = $this->pdo->prepare(
            "SELECT user_id FROM password_resets
             WHERE token = ? AND expires_at > NOW()"
        );
        $stmt->execute([$token]);

        return $stmt->fetch(PDO::FETCH_COLUMN) ?: null;
    }

    /**
     * Invalida um token após uso
     */
    public function invalidateToken(string $token): bool
    {
        return $this->pdo->prepare(
            "DELETE FROM password_resets WHERE token = ?"
        )->execute([$token]);
    }

    /**
     * Remove tokens expirados (para ser executado periodicamente)
     */
    public function cleanupExpiredTokens(): int
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM password_resets WHERE expires_at <= NOW()"
        );
        $stmt->execute();
        return $stmt->rowCount();
    }

    /**
     * Verifica se um usuário tem solicitação pendente
     */
    public function hasPendingRequest(int $userId): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM password_resets
             WHERE user_id = ? AND expires_at > NOW()"
        );
        $stmt->execute([$userId]);
        return (bool)$stmt->fetch(PDO::FETCH_COLUMN);
    }
}
