<?php

namespace App\Models;

use App\Config\Database;

class EmailVerification
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function create(int $userId): string
    {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $this->pdo->prepare(
            "INSERT INTO email_verifications (user_id, token, expires_at)
             VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE token = ?, expires_at = ?"
        )
            ->execute([$userId, $token, $expires, $token, $expires]);

        return $token;
    }

    public function validate(string $token): ?int
    {
        $stmt = $this->pdo->prepare(
            "SELECT user_id FROM email_verifications 
             WHERE token = ? AND expires_at > NOW()"
        );
        $stmt->execute([$token]);
        return $stmt->fetchColumn() ?: null;
    }
}
