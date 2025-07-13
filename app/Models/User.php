<?php

namespace App\Models;

use App\Config\Database;

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name, email, password_hash) 
             VALUES (:name, :email, :password)"
        );
        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT)
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function updatePassword(int $userId, string $newPassword): bool
    {
        // Validação básica da senha
        if (strlen($newPassword) < 8) {
            throw new \InvalidArgumentException("A senha deve ter pelo menos 8 caracteres");
        }

        $stmt = $this->pdo->prepare(
            "UPDATE users 
         SET password_hash = :hash 
         WHERE id = :id"
        );

        return $stmt->execute([
            ':hash' => password_hash($newPassword, PASSWORD_BCRYPT),
            ':id' => $userId
        ]);
    }

    public function verifyCurrentPassword(int $userId, string $currentPassword): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT password_hash FROM users WHERE id = ?"
        );
        $stmt->execute([$userId]);
        $hash = $stmt->fetchColumn();

        return password_verify($currentPassword, $hash);
    }

    public function markAsVerified(int $userId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET is_verified = TRUE WHERE id = ?");
        return $stmt->execute([$userId]);
    }
}
